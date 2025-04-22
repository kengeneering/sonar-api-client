<?php

namespace Kengineering\Sonar;

use DateTime;
use Kengineering\Sonar\Operations\Query;
use Exception;
use Kengineering\Sonar\Enums\SortDirection;

class Sort
{
    const VARIABLE_IMPORT_NAME = '[Sorter]';

    /**
     * @var array<array<SortDirection|string>>
     */
    private $sorts = [];

    private ?Query $parent_query;

    public function __construct(?Query $parent_query = null)
    {
        $this->parent_query = $parent_query;
    }

    public function addVarsToQuery(Query $query): Query
    {
        if (count($this->sorts)) {
            $query->addVariable(['sorter' => $this->sorts], self::VARIABLE_IMPORT_NAME);
        }

        return $query;
    }

    public function sortBy(string $attribute, SortDirection $direction): ?Query
    {
        $this->sorts[] = [
            'attribute' => $attribute,
            'direction' => $direction,
        ];

        return $this->parent_query;
    }

}
