<?php

namespace Kengineering\Tests\Unit\Sonar;

use Kengineering\Sonar\Objects\Account;
use Kengineering\Sonar\Objects\AccountStatus;
use Kengineering\Sonar\Objects\Address;
use Kengineering\Sonar\Operations\Query;
use Kengineering\Sonar\Search;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    public function test_basic_query()
    {
        $query = (new Query(AccountStatus::class))->add(Account::class);

        $this->assertEquals('account_statuses { entities {id sonar_unique_id created_at updated_at _version activates_account color icon name accounts { entities {id sonar_unique_id created_at updated_at _version account_status_id account_type_id activation_date activation_time company_id data_usage_percentage is_delinquent name next_bill_date next_recurring_charge_amount parent_account_id}}}}', (string) $query);
    }

    public function test_parent_and_child_functions()
    {
        $query = (new Query(AccountStatus::class))
            ->addToChild(Account::class)
            ->addToParent(Account::class)
            ->addToChild(AccountStatus::class);

        $this->assertEquals('account_statuses { entities {id sonar_unique_id created_at updated_at _version activates_account color icon name accounts { entities {id sonar_unique_id created_at updated_at _version account_status_id account_type_id activation_date activation_time company_id data_usage_percentage is_delinquent name next_bill_date next_recurring_charge_amount parent_account_id}} accounts { entities {id sonar_unique_id created_at updated_at _version account_status_id account_type_id activation_date activation_time company_id data_usage_percentage is_delinquent name next_bill_date next_recurring_charge_amount parent_account_id account_status {id sonar_unique_id created_at updated_at _version activates_account color icon name}}}}}', (string) $query);
    }

    public function test_query_build()
    {
        $query = new Query(AccountStatus::class);
        $Gquery = $query->build();

        $this->assertMatchesRegularExpression(
            '/account_statuses\(paginator: \$[a-z]{26} \) { entities {id sonar_unique_id created_at updated_at _version activates_account color icon name}}/',
            (string) $query
        );
        $paginator_variables = $Gquery->getVariables()['paginator'];
        $this->assertEquals([
            'page' => 1,
            'records_per_page' => 100,
        ], $paginator_variables['data']);
        $this->assertEquals('Paginator', $paginator_variables['type']);
    }

    public function test_build_owned_by_query()
    {
        $query = Address::query()->addToChild(Account::class);
        $this->assertEquals('addresses { entities {id sonar_unique_id created_at updated_at _version address_status_id addressable_id addressable_type anchor_address_id attainable_download_speed attainable_upload_speed avalara_pcode billing_default_id census_year city country county fips fips_source is_anchor latitude line1 line2 longitude serviceable subdivision timezone type zip addressable { __typename ... on  Account {id sonar_unique_id created_at updated_at _version account_status_id account_type_id activation_date activation_time company_id data_usage_percentage is_delinquent name next_bill_date next_recurring_charge_amount parent_account_id}}}}', (string) $query);
    }

    public function test_custom_paginator()
    {
        $query = new Query(AccountStatus::class);
        $query->paginate(200, 2);
        $Gquery = $query->build();

        //dd($Gquery);
        $this->assertMatchesRegularExpression(
            '/account_statuses\(paginator: \$[a-z]{26} \) { entities {id sonar_unique_id created_at updated_at _version activates_account color icon name}}/',
            (string) $query
        );
        $paginator_variables = $Gquery->getVariables()['paginator'];
        $this->assertEquals([
            'page' => 2,
            'records_per_page' => 200,
        ], $paginator_variables['data']);
        $this->assertEquals('Paginator', $paginator_variables['type']);
    }

    public function test_reverse_relation_search()
    {
        $query = (new Query(AccountStatus::class))->add(Account::class);
        $query->reverseRelationSearch('accounts', function (Search $search) {
            $search->stringSearch('name', 'test');
        });
        $Gquery = $query->build();

        $this->assertMatchesRegularExpression(
            '/account_statuses\(reverse_relation_filters: \$[a-z]{26} paginator: \$[a-z]{26} \) { entities {id sonar_unique_id created_at updated_at _version activates_account color icon name accounts { entities {id sonar_unique_id created_at updated_at _version account_status_id account_type_id activation_date activation_time company_id data_usage_percentage is_delinquent name next_bill_date next_recurring_charge_amount parent_account_id}}}}/',
            (string) $query
        );
        $rrf_variables = $Gquery->getVariables()['reverse_relation_filters'];
        $this->assertEquals([
            [
                'relation' => 'accounts',
                'search' => [
                    [
                        'string_fields' => [
                            [
                                'attribute' => 'name',
                                'search_value' => 'test',
                                'match' => true,
                                'partial_matching' => true,
                            ],
                        ],
                    ],
                ],
                'is_empty' => false,
                'group' => '1',
            ],
        ], $rrf_variables['data']);
        $this->assertEquals('[ReverseRelationFilter]', $rrf_variables['type']);
    }

    public function test_parse_results_to_objects()
    {
        $query = new Query(AccountStatus::class);

        $result = [
            'entities' => [
                [
                    'id' => 'fake_value',
                    'sonar_unique_id' => 'fake_value',
                    'created_at' => 'fake_value',
                    'updated_at' => 'fake_value',
                    '_version' => 'fake_value',
                    'activates_account' => 'fake_value',
                    'color' => 'fake_value',
                    'icon' => 'fake_value',
                    'name' => 'fake_value',
                ],
                [
                    'id' => 'fake_value',
                    'sonar_unique_id' => 'fake_value',
                    'created_at' => 'fake_value',
                    'updated_at' => 'fake_value',
                    '_version' => 'fake_value',
                    'activates_account' => 'fake_value',
                    'color' => 'fake_value',
                    'icon' => 'fake_value',
                    'name' => 'fake_value',
                ],
                [
                    'id' => 'fake_value',
                    'sonar_unique_id' => 'fake_value',
                    'created_at' => 'fake_value',
                    'updated_at' => 'fake_value',
                    '_version' => 'fake_value',
                    'activates_account' => 'fake_value',
                    'color' => 'fake_value',
                    'icon' => 'fake_value',
                    'name' => 'fake_value',
                ],
            ],
        ];

        $results = $query->parseResultsToObjects($result);

        $this->assertEquals(3, count($results));
        $this->assertEquals('fake_value', $results[0]->name);
        $this->assertEquals('fake_value', $results[0]->id);
        $this->assertEquals('fake_value', $results[0]->color);
        $this->assertEquals('fake_value', $results[0]->icon);
    }
}
