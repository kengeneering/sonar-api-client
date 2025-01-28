<?php

namespace Kengineering\Sonar\Graphql;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Request
{
    /** @var Query[] */
    protected array $operations = [];

    private ?Client $client;

    protected string $type = 'query';

    /** @var array<array<mixed|string>> */
    protected array $variables = [];

    /**
     * @param  array<Query>  $operations
     */
    public function __construct(string $type = 'query', array $operations = [], ?Client $client = null)
    {

        $this->client = $client;

        if (!in_array($type, ['query', 'mutation'], true)) {
            throw new \InvalidArgumentException('Type must be either "query" or "mutation"');
        }
        $this->type = $type;
        $this->addOperations($operations);
    }

    /**
     * @param  array<Query>  $operations
     */
    public function addOperations(array $operations): Request
    {
        $this->operations = array_merge($this->operations, $operations);

        return $this;
    }

    public function addOperation(Query $operation, ?string $access_name = null): Request
    {
        if (isset($this->operations[$access_name])) {
            throw new \InvalidArgumentException('Invalid access name');
        }
        $operation_array = isset($access_name) ? [$access_name => $operation] : [$operation];

        return $this->addOperations($operation_array);
    }

    public function buildRequest(): string
    {
        $request_body = $this->type . ' request';
        $variable_definition = '';
        $fields_body = '';
        foreach ($this->operations as $i => $operation) {
            $operation = $operation->build();
            foreach ($operation->getVariables() as $name => $variable) {
                /** @var array<array|mixed> $data */
                $data = $variable['data'];
                $this->variables[$variable['name']] = $data;
                $variable_definition .= ' $' . $variable['name'] . ': ' . $variable['type'] . ($variable['required'] ? '! ' : ' ');
            }
            $fields_body .= (string) ($operation->setAlias("operation_$i"));
        }

        if ($variable_definition) {
            $variable_definition = '(' . $variable_definition . ')';
        }

        $request_body .= $variable_definition . ' {' . $fields_body . ' }';

        return $request_body;
    }

    /**
     * @return array<array<array|mixed>>
     */
    public function sendRequest()
    {
        $query = $this->buildRequest();
        $result = $this->rawQuery($query, $this->variables, $this->client);

        if (!$result['success']) {
            throw new \InvalidArgumentException(print_r($result, true));
        }

        return $result['data'];
    }

    /**
     * @param  array<array|mixed>  $variables
     * @return array<array|mixed>
     */
    public function rawQuery(string $query = '', array $variables = [], ?Client $client = null)
    {
        if (!isset($_ENV['SONAR_URL']) || !isset($_ENV['SONAR_KEY'])) {
            throw new \InvalidArgumentException('Missing required Sonar credentials in .env file');
        }

        if (is_null($client)) {
            $client = new Client();// @codeCoverageIgnore
        }

        $post_data = [
            'query' => $query,
            'variables' => $variables,
        ];

        $response_data = [
            'success' => true,
            'data' => [],
        ];

        try {
            $result = $client->post($_ENV['SONAR_URL'], [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Cache-Control' => 'no-cache',
                    'Authorization' => 'Bearer ' . $_ENV['SONAR_KEY'],
                ],
                'json' => $post_data,
                'timeout' => 30,
                'allow_redirects' => ['max' => 1]
            ]);

            $status = $result->getStatusCode();

            if ($status >= 200 && $status < 300) {
                $data = json_decode($result->getBody()->getContents(), true);
            } else {
                $response_data['errors'] = ['we are having some server issues'];
                $response_data['success'] = false;

                return $response_data;
            }

            if (isset($data['errors']) && !empty($data['errors'])) {
                $response_data['success'] = false;
                $response_data['errors'] = $data['errors'];
            } else {
                $response_data['success'] = true;
                $response_data['data'] = $data['data'];
            }

            return $response_data;

        } catch (RequestException $e) {
            $response_data['errors'] = ['we are having some server issues'];
            $response_data['success'] = false;

            return $response_data;
        }
    }
}
