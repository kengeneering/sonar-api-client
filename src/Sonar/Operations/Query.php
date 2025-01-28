<?php

namespace Kengineering\Sonar\Operations;

use Kengineering\DataStructures\Node;
use Kengineering\Sonar\Graphql\Query as GraphqlQuery;
use Kengineering\Sonar\Objects\SonarObject;
use Kengineering\Sonar\Request;
use Kengineering\Sonar\Search;
use Exception;
use GuzzleHttp\Client;

class Query extends GraphqlQuery
{
    private Node $root_node;

    private Node $node_pointer;

    private ?Client $client;

    public Search $search;

    /**
     * @var array<array<mixed>>|null
     */
    private $reverse_relation_searches;

    private int $page = 1;

    private int $records_num = 100;

    public function __construct(string $root_object, ?Client $client = null)
    {
        $this->client = $client;

        $this->search = new Search($this);
        $this->root_node = new Node($root_object);
        $this->node_pointer = $this->root_node;
    }

    public function add(string $object): self
    {
        /** @var string $value */
        $value = $this->node_pointer->value;
        $value::object_relationship($object);

        $child_node = new Node($object);
        $this->node_pointer = $this->node_pointer->addChild($child_node);

        return $this;
    }

    public function end(): self
    {
        $this->node_pointer = $this->node_pointer->parent();

        return $this;
    }

    public function addToChild(string $object): self
    {
        return $this->add($object);
    }

    public function addToParent(string $object): self
    {
        $this->end();

        return $this->add($object);

    }

    public function __toString(): string
    {
        $query = $this->recurse_object_tree($this->root_node)->setAlias($this->alias);
        $query->variables = $this->variables;

        return (string) $query;
    }

    /**
     * @return array<\Kengineering\Sonar\Objects\SonarObject>
     */
    public function get()
    {
        $request = new Request('query', [$this], $this->client);

        $results = $request->get();

        return $results[0];
    }

    public function first(): ?SonarObject
    {
        return $this->get()[0] ?? null;
    }

    public function build(): self
    {
        $query = $this->recurse_object_tree($this->root_node);
        $this->setUpVariables($query);
        $query->variables = $this->variables;

        return $this;
    }

    /**
     * @param  array<array<mixed>>  $results
     * @return array<\Kengineering\Sonar\Objects\SonarObject>
     */
    public function parseResultsToObjects($results)
    {
        /** @var class-string<\Kengineering\Sonar\Objects\SonarObject> $root_object */
        $root_object = $this->root_node->value;

        $objects = [];

        foreach ($results['entities'] as $object) {

            $objects[] = new $root_object($object, true);

        }

        return $objects;
    }

    private function setUpVariables(GraphqlQuery $query): GraphqlQuery
    {
        $query = $this->search->addVarsToQuery($this);
        $query = $this->setRRF();
        $query = $this->setPagination();

        return $query;
    }

    private function setRRF(): self
    {
        if (isset($this->reverse_relation_searches)) {
            $this->addVariable(['reverse_relation_filters' => $this->reverse_relation_searches], '[ReverseRelationFilter]');
        }

        return $this;
    }

    private function setPagination(): self
    {
        $this->addVariable(['paginator' => ['page' => $this->page, 'records_per_page' => $this->records_num]], 'Paginator');

        return $this;
    }

    private function recurse_object_tree(Node $root_node, ?Node $parent_node = null): GraphqlQuery
    {
        $inner_queries = [];
        foreach ($root_node->children() as $child) {
            $inner_queries[] = $this->recurse_object_tree($child, $root_node);
        }

        /** @var class-string<\Kengineering\Sonar\Objects\SonarObject> $root_object */
        $root_object = $root_node->value;

        // @phpstan-ignore-next-line
        $object_name = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', basename(str_replace('\\', '/', $root_object))));
        if (!isset($parent_node)) {
            $relationship = 'many';
        } else {
            /** @var class-string<\Kengineering\Sonar\Objects\SonarObject> $parent_value */
            $parent_value = $parent_node->value;
            $relationship_values = $parent_value::object_relationship($root_object);
            $custom_access_name = $relationship_values['access_name'] ?? null;
            $relationship = $relationship_values['relationship'];
        }

        $inner_properties = [
            ...$root_object::PROPERTIES,
            ...$inner_queries,
        ];

        if ($relationship === 'many') {

            $access_name = $custom_access_name ?? ($root_object::OBJECT_MULTIPLE_NAME ?? "{$object_name}s");
            $fields_array = [
                (new GraphqlQuery('entities', $inner_properties)),
            ];
        } elseif ($relationship === 'one') {

            $access_name = $custom_access_name ?? ($root_object::OBJECT_SINGLE_NAME ?? $object_name);
            $fields_array = $inner_properties;
        } elseif ($relationship === 'owned_by') {
            $fields_array = [
                (new GraphqlQuery('__typename ... on  ' . ucfirst($root_object::OBJECT_SINGLE_NAME ?? $object_name), $inner_properties)),
            ];
            $access_name = $custom_access_name ?? (($parent_value ?? '')::OWNED_ACCESS_NAME);
        } else {
            throw new Exception('undefined relationsip type');
        }

        return new GraphqlQuery($access_name, $fields_array);
    }

    public function reverseRelationSearch(string $relation, callable $rrf_search, bool $is_empty = false, int $group = 1): self
    {

        $rrf = new Search;
        $rrf_search($rrf);

        $inner_search = $rrf->getSearchArray();

        $this->reverse_relation_searches[] =
            [
                'relation' => $relation,
                'search' => [$inner_search],
                'is_empty' => $is_empty,
                'group' => $group,
            ];

        return $this;
    }


    ## :TODO flip the order of paramaters to be able to just set the number of records
    public function paginate(int $records_per_page = 100, int $page = 1): self
    {
        $this->page = $page;
        $this->records_num = $records_per_page;

        return $this;
    }
}
