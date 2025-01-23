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

    public function __construct(SonarObject $object = (new SonarObject([])), string $type = '', ?GraphqlQuery $raw_query = null, ?Client $client = null)
    {
        $this->client = $client;
        if (isset($raw_query)) {
            $this->raw_query = $raw_query;
        } else {
            if (!in_array($type, ['create', 'update', 'delete'], true)) {
                throw new \InvalidArgumentException('Type must be either "create". "delete" or "update"');
            }
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
            $required_properties = array_intersect_key($object->toArray(), $this->object->get_mutate_properties($type));
            $this->addVariable(['input' => $required_properties], $mutation_input_name);

            $query->addVariable(['input' => $required_properties], $mutation_input_name);

        }
        if (in_array($type, ['update', 'delete'], true)) {
            $query->addVariable(['id' => $object->id], 'Int64Bit', true);
            $this->addVariable(['id' => $object->id], 'Int64Bit', true);
        }


        return $query;
    }
}
