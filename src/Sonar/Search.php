<?php

namespace Kengineering\Sonar;

use Kengineering\Sonar\Operations\Query;
use Exception;

class Search
{
    const VARIABLE_IMPORT_NAME = '[Search]';

    const RANGE_OPERATORS = ['>=' => 'GTE', '>' => 'GT', '<=' => 'LTE', '<' => 'LT', '==' => 'EQ', '!=' => 'NEQ'];

    /**
     * @var array<array<array<mixed>>>
     */
    private $sub_searches = [];

    private ?Query $parent_query;

    public function __construct(?Query $parent_query = null)
    {
        $this->parent_query = $parent_query;
    }

    public function addVarsToQuery(Query $query): Query
    {
        if (count($this->sub_searches)) {
            $query->addVariable(['search' => [$this->sub_searches]], self::VARIABLE_IMPORT_NAME);
        }

        return $query;
    }

    /**
     * @param  array<mixed>  $attributes
     */
    private function addSearch(array $attributes, string $type = 'string_fields'): void
    {
        $this->sub_searches[$type][] = $attributes;
    }

    /**
     * @return array<array<array<mixed>>>
     */
    public function getSearchArray(): array
    {
        return $this->sub_searches;
    }

    public function stringSearch(string $attribute, mixed $value, bool $match = true, bool $partial_matching = true): ?Query
    {
        $this->addSearch(
            [
                'attribute' => $attribute,
                'search_value' => $value,
                'match' => $match,
                'partial_matching' => $partial_matching,
            ],
            'string_fields'
        );

        return $this->parent_query;
    }

    public function intSearch(string $attribute, int $value, string $range_operator = '=='): ?Query
    {
        $this->checkRangeOperator($range_operator);
        $range_operator = self::RANGE_OPERATORS[$range_operator];

        $this->addSearch(
            [
                'attribute' => $attribute,
                'search_value' => $value,
                'operator' => $range_operator,
            ],
            'integer_fields'
        );

        return $this->parent_query;
    }

    public function floatSearch(string $attribute, float $value, string $range_operator = '='): ?Query
    {
        $this->checkRangeOperator($range_operator);
        $range_operator = self::RANGE_OPERATORS[$range_operator];

        $this->addSearch(
            [
                'attribute' => $attribute,
                'search_value' => $value,
                'operator' => $range_operator,
            ],
            'float_fields'
        );

        return $this->parent_query;
    }

    public function booleanSearch(string $attribute, bool $value = true): ?Query
    {

        $this->addSearch(
            [
                'attribute' => $attribute,
                'search_value' => $value,
            ],
            'boolean_fields'
        );

        return $this->parent_query;
    }

    private function checkRangeOperator(string $range_operator): void
    {
        if (! isset(self::RANGE_OPERATORS[$range_operator])) {
            throw new Exception('Invalid Range Operator');
        }
    }
}
