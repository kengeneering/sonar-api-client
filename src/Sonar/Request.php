<?php

namespace Kengineering\Sonar;

use Kengineering\Sonar\Graphql\Request as GraphqlRequest;
use Kengineering\Sonar\Objects\SonarObject;
use Kengineering\Sonar\Operations\Mutation;
use Kengineering\Sonar\Operations\Query;

class Request extends GraphqlRequest
{
    /**
     * @param  array<SonarObject|Query|Mutation>  $operations
     */
    public function addOperations($operations): Request
    {
        foreach ($operations as $name => $operation) {
            if ($operation instanceof SonarObject) {
                $operation = $operation->batch();
            } elseif (($operation instanceof Mutation && $this->type === 'mutation') || ($operation instanceof Query && $this->type === 'query')) {
            } else {
                throw new \Exception('bad request made');
            }
            $this->operations[$name] = $operation;
        }

        return $this;
    }

    /**
     * @return array<array<\Kengineering\Sonar\Objects\SonarObject>>
     *
     * @throws \Exception
     */
    public function get()
    {
        if ($this->type !== 'query') {
            throw new \Exception('Cannot call this function on a mutation');
        }

        $results = $this->sendRequest();

        $objectified_results = [];

        /**
         * @var array<\Kengineering\Sonar\Operations\Query> $operations
         */
        $operations = $this->operations;

        foreach ($operations as $i => $operation) {
            $objectified_results[$i] = $operation->parseResultsToObjects($results["operation_$i"]);
        }

        return $objectified_results;
    }

    public function mutate(): void
    {
        if ($this->type !== 'mutation') {
            throw new \Exception('Cannot call this function on a query');
        }

        $results = $this->sendRequest();

        //#implement returning a raw array of the mutations
    }
}
