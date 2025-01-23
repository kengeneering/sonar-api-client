<?php

namespace Kengineering\Tests\Unit\Sonar;

use Kengineering\Sonar\Objects\AccountStatus;
use Kengineering\Sonar\Operations\Query;
use Kengineering\Sonar\Search;
use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    public function test_string_search()
    {
        $query = new Query(AccountStatus::class);

        $search = new Search($query);
        $search->stringSearch('name', 'test_name');

        $search->addVarsToQuery($query);

        $this->assertMatchesRegularExpression(
            '/account_statuses\(search: \$[a-z]{26} \) { entities {id sonar_unique_id created_at updated_at _version activates_account color icon name}}/',
            (string) $query
        );
        $variables = $query->getVariables()['search'];
        $this->assertSame(
            [
                [
                    'string_fields' => [
                        [
                            'attribute' => 'name',
                            'search_value' => 'test_name',
                            'match' => true,
                            'partial_matching' => true,
                        ],
                    ],
                ],
            ],
            $variables['data']
        );
        $this->assertEquals($variables['type'], '[Search]');
        $this->assertEquals($variables['required'], false);
        $this->assertEquals(strlen($variables['name']), 26);
    }

    public function test_int_search()
    {
        $query = new Query(AccountStatus::class);

        $search = new Search($query);
        $search->intSearch('fake_int', 123, '>=');

        $search->addVarsToQuery($query);

        $this->assertMatchesRegularExpression(
            '/account_statuses\(search: \$[a-z]{26} \) { entities {id sonar_unique_id created_at updated_at _version activates_account color icon name}}/',
            (string) $query
        );
        $variables = $query->getVariables()['search'];
        $this->assertSame(
            [
                [
                    'integer_fields' => [
                        [
                            'attribute' => 'fake_int',
                            'search_value' => 123,
                            'operator' => 'GTE',
                        ],
                    ],
                ],
            ],
            $variables['data']
        );
        $this->assertEquals(strlen($variables['name']), 26);
    }

    public function test_float_search()
    {
        $query = new Query(AccountStatus::class);

        $search = new Search($query);
        $search->floatSearch('fake_int', 123.123, '>=');

        $search->addVarsToQuery($query);

        $this->assertMatchesRegularExpression(
            '/account_statuses\(search: \$[a-z]{26} \) { entities {id sonar_unique_id created_at updated_at _version activates_account color icon name}}/',
            (string) $query
        );
        $variables = $query->getVariables()['search'];
        $this->assertSame(
            [
                [
                    'float_fields' => [
                        [
                            'attribute' => 'fake_int',
                            'search_value' => 123.123,
                            'operator' => 'GTE',
                        ],
                    ],
                ],
            ],
            $variables['data']
        );
        $this->assertEquals(strlen($variables['name']), 26);
    }

    public function test_bool_search()
    {
        $query = new Query(AccountStatus::class);

        $search = new Search($query);
        $search->booleanSearch('fake_bool', false);

        $search->addVarsToQuery($query);

        $this->assertMatchesRegularExpression(
            '/account_statuses\(search: \$[a-z]{26} \) { entities {id sonar_unique_id created_at updated_at _version activates_account color icon name}}/',
            (string) $query
        );
        $variables = $query->getVariables()['search'];
        $this->assertSame(
            [
                [
                    'boolean_fields' => [
                        [
                            'attribute' => 'fake_bool',
                            'search_value' => false,
                        ],
                    ],
                ],
            ],
            $variables['data']
        );
        $this->assertEquals(strlen($variables['name']), 26);
    }

    public function test_check_searches()
    {
        $query = new Query(AccountStatus::class);

        $search = new Search($query);
        $search->booleanSearch('fake_bool', false);
        $searches = $search->getSearchArray();

        $this->assertSame(
            [
                'boolean_fields' => [
                    [
                        'attribute' => 'fake_bool',
                        'search_value' => false,
                    ],
                ],
            ],
            $searches
        );
    }

    public function test_invalid_operator()
    {
        $query = new Query(AccountStatus::class);

        $search = new Search($query);
        $this->expectException(\Exception::class);
        $search->floatSearch('fake_int', 123.123, '>==');
    }

    public function test_range_operators()
    {
        $operators = Search::RANGE_OPERATORS;
        $this->assertEquals($operators['>='], 'GTE');
        $this->assertEquals($operators['>'], 'GT');
        $this->assertEquals($operators['<='], 'LTE');
        $this->assertEquals($operators['<'], 'LT');
        $this->assertEquals($operators['!='], 'NEQ');
        $this->assertEquals($operators['=='], 'EQ');

    }
}
