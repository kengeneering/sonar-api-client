<?php

namespace Kengineering\Sonar\Operations;

use Kengineering\Sonar\Graphql\Query as GraphqlQuery;
use Kengineering\Sonar\Objects\SonarObject;
use Kengineering\Sonar\Request;
use GuzzleHttp\Client;

class Mutation extends GraphqlQuery
{
    //######
    //
    //
    //  Only Directly interface with this class if you know what you are doing
    //
    //

    private string $type;

    private SonarObject $object;

    public GraphqlQuery $raw_query;
    private ?Client $client;
    /**
     * @var  ?array<mixed>  $delete_input
     */
    private ?array $delete_input;
    /**
     * @param  ?array<mixed>  $delete_input
     */
    public function __construct(
        SonarObject $object = (new SonarObject([])),
        string $type = '',
        array $delete_input = null,
        ?GraphqlQuery $raw_query = null,
        ?Client $client = null
    ) {
        $this->client = $client;
        if (isset($raw_query)) {
            $this->raw_query = $raw_query;
        } else {
            if (!in_array($type, ['create', 'update', 'delete'], true)) {
                throw new \InvalidArgumentException('Type must be either "create". "delete" or "update"');
            }
            $this->delete_input = $delete_input;
            $this->object = $object;
            $this->type = $type;
        }
    }

    /**
     * @return array<mixed|int>
     */
    public function execute()
    {
        $request = new Request('mutation', [$this], $this->client);

        return $request->sendRequest()['operation_0'];
    }

    public function build(): GraphqlQuery
    {
        if (isset($this->raw_query) && !isset($this->object)) {
            return $this->raw_query;
        }
        $object = $this->object;
        $type = $this->type;

        $mutation_name = $object->get_mutation_name($type);
        $mutation_input_name = $object->get_mutation_input_name($type);

        if ($type === 'delete') {
            $return_properties = ['success', 'message'];
        } else {
            $return_properties = $object::PROPERTIES;
        }

        $query = new GraphqlQuery($mutation_name, $return_properties);

        if (in_array($type, ['update', 'create'], true)) {
            $required_properties = [];

            foreach ($this->object->get_mutate_properties($type) as $property => $value) {
                if (!is_null($object->$property)) {
                    $required_properties[$property] = $object->$property;
                }
            }

            $this->addVariable(['input' => $required_properties], $mutation_input_name);

            $query->addVariable(['input' => $required_properties], $mutation_input_name);

        }
        if (in_array($type, ['update', 'delete'], true)) {
            $query->addVariable(['id' => $object->id], 'Int64Bit', true);
            $this->addVariable(['id' => $object->id], 'Int64Bit', true);
        }
        if (in_array($type, ['delete'])) {
            if (!is_null($this->delete_input)) {
                $query->addVariable(['input' => $this->delete_input], $mutation_input_name, false);
                $this->addVariable(['input' => $this->delete_input], $mutation_input_name, false);
            }
        }


        return $query;
    }
}
