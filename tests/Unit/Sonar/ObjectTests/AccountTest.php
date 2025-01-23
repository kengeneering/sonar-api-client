<?php

namespace tests\Unit\Sonar\ObjectTests;

use Kengineering\Sonar\Graphql\Query;
use Kengineering\Sonar\Objects\Account;
use Kengineering\Sonar\Operations\Mutation;
use PHPUnit\Framework\TestCase;
use Kengineering\Sonar\Objects\Service;
use Kengineering\Sonar\Objects\Package;

class AccountTest extends TestCase
{
    public function test_cant_add_service_account_does_not_exist()
    {

        $account = new Account([
            'id' => 'fake_value',
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'account_status_id' => 'fake_value',
            'account_type_id' => 'fake_value',
            'activation_date' => 'fake_value',
            'activation_time' => 'fake_value',
            'company_id' => 'fake_value',
            'data_usage_percentage' => 'fake_value',
            'is_delinquent' => 'fake_value',
            'name' => 'fake_value',
            'next_bill_date' => 'fake_value',
            'next_recurring_charge_amount' => 'fake_value',
            'parent_account_id' => 'fake_value',
        ]);

        $this->expectException(\Exception::class);

        $account->addService(3);

    }

    public function test_batched_request()
    {
        $account = new Account([
            'id' => 'fake_value',
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'account_status_id' => 'fake_value',
            'account_type_id' => 'fake_value',
            'activation_date' => 'fake_value',
            'activation_time' => 'fake_value',
            'company_id' => 'fake_value',
            'data_usage_percentage' => 'fake_value',
            'is_delinquent' => 'fake_value',
            'name' => 'fake_value',
            'next_bill_date' => 'fake_value',
            'next_recurring_charge_amount' => 'fake_value',
            'parent_account_id' => 'fake_value',
        ], true);

        $query = (new Query('addServiceToAccount', ['id']))->addVariable(['input' => ['service_id' => 12321, 'account_id' => 'fake_value', 'quantity' => 1]], 'AddServiceToAccountMutationInput');

        $mutation = new Mutation(raw_query: $query);

        $mutation_vars = $mutation->build()->getVariables();
        $add_service_vars = $account->addService(12321, true)->build()->getVariables();

        $this->assertEquals($mutation_vars['input']['data'], $add_service_vars['input']['data']);
        $this->assertEquals($mutation_vars['input']['type'], $add_service_vars['input']['type']);

    }
    public function test_add_service_pass_service_object_as_param()
    {
        $account = new Account([
            'id' => 'fake_value',
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'account_status_id' => 'fake_value',
            'account_type_id' => 'fake_value',
            'activation_date' => 'fake_value',
            'activation_time' => 'fake_value',
            'company_id' => 'fake_value',
            'data_usage_percentage' => 'fake_value',
            'is_delinquent' => 'fake_value',
            'name' => 'fake_value',
            'next_bill_date' => 'fake_value',
            'next_recurring_charge_amount' => 'fake_value',
            'parent_account_id' => 'fake_value',
        ], true);

        $service = new Service([
            'id' => 32123,
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'amount' => 'fake_value',
            'application' => 'fake_value',
            'company_id' => 'fake_value',
            'display_if_zero' => 'fake_value',
            'enabled' => 'fake_value',
            'general_ledger_code_id' => 'fake_value',
            'name' => 'fake_value',
            'reverse_tax_definition_id' => 'fake_value',
            'tax_definition_id' => 'fake_value',
            'type' => 'fake_value',
        ], true);

        $mutation = $account->addService($service, true);

        $expected_query = (new Query('addServiceToAccount', ['id']))->addVariable(['input' => ['service_id' => 32123, 'account_id' => $account->id, 'quantity' => 1]], 'AddServiceToAccountMutationInput');
        $expected_mutation = new Mutation(raw_query: $expected_query);

        $this->assertEquals($mutation->raw_query->getVariables()['input']['data'], $expected_mutation->raw_query->getVariables()['input']['data']);
        $this->assertEquals($mutation->raw_query->getVariables()['input']['type'], $expected_mutation->raw_query->getVariables()['input']['type']);


    }

    public function test_add_package_pass_package_object_as_param()
    {
        $account = new Account([
            'id' => 'fake_value',
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'account_status_id' => 'fake_value',
            'account_type_id' => 'fake_value',
            'activation_date' => 'fake_value',
            'activation_time' => 'fake_value',
            'company_id' => 'fake_value',
            'data_usage_percentage' => 'fake_value',
            'is_delinquent' => 'fake_value',
            'name' => 'fake_value',
            'next_bill_date' => 'fake_value',
            'next_recurring_charge_amount' => 'fake_value',
            'parent_account_id' => 'fake_value',
        ], true);

        $package = new Package([
            'id' => 32123,
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'company_id' => 'fake_value',
            'enabled' => 'fake_value',
            'name' => 'fake_value',
            'rollup_services' => 'fake_value',
        ], true);

        $mutation = $account->addPackage($package, true);

        $expected_query = (new Query('addPackageToAccount', ['id']))->addVariable(['input' => ['package_id' => 32123, 'account_id' => $account->id, 'quantity' => 1]], 'AddPackageToAccountMutationInput');
        $expected_mutation = new Mutation(raw_query: $expected_query);

        $this->assertEquals($mutation->raw_query->getVariables()['input']['data'], $expected_mutation->raw_query->getVariables()['input']['data']);
        $this->assertEquals($mutation->raw_query->getVariables()['input']['type'], $expected_mutation->raw_query->getVariables()['input']['type']);

    }

    public function test_get_serviceable_address_address_included()
    {
        $account = new Account([
            'id' => 'fake_value',
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'account_status_id' => 'fake_value',
            'account_type_id' => 'fake_value',
            'activation_date' => 'fake_value',
            'activation_time' => 'fake_value',
            'company_id' => 'fake_value',
            'data_usage_percentage' => 'fake_value',
            'is_delinquent' => 'fake_value',
            'name' => 'fake_value',
            'next_bill_date' => 'fake_value',
            'next_recurring_charge_amount' => 'fake_value',
            'parent_account_id' => 'fake_value',
            'addresses' => [
                'entities' => [
                    [
                        'id' => 321,
                        'sonar_unique_id' => 'fake_value',
                        'created_at' => 'fake_value',
                        'updated_at' => 'fake_value',
                        '_version' => 'fake_value',
                        'address_status_id' => 'fake_value',
                        'addressable_id' => 'fake_value',
                        'addressable_type' => 'fake_value',
                        'anchor_address_id' => 'fake_value',
                        'attainable_download_speed' => 'fake_value',
                        'attainable_upload_speed' => 'fake_value',
                        'avalara_pcode' => 'fake_value',
                        'billing_default_id' => 'fake_value',
                        'census_year' => 'fake_value',
                        'city' => 'fake_value',
                        'country' => 'fake_value',
                        'county' => 'fake_value',
                        'fips' => 'fake_value',
                        'fips_source' => 'fake_value',
                        'is_anchor' => 'fake_value',
                        'latitude' => 'fake_value',
                        'line1' => 'fake_value',
                        'line2' => 'fake_value',
                        'longitude' => 'fake_value',
                        'serviceable' => false,
                        'subdivision' => 'fake_value',
                        'timezone' => 'fake_value',
                        'type' => 'fake_value',
                        'zip' => 'fake_value',
                    ],
                    [
                        'id' => 123,
                        'sonar_unique_id' => 'fake_value',
                        'created_at' => 'fake_value',
                        'updated_at' => 'fake_value',
                        '_version' => 'fake_value',
                        'address_status_id' => 'fake_value',
                        'addressable_id' => 'fake_value',
                        'addressable_type' => 'fake_value',
                        'anchor_address_id' => 'fake_value',
                        'attainable_download_speed' => 'fake_value',
                        'attainable_upload_speed' => 'fake_value',
                        'avalara_pcode' => 'fake_value',
                        'billing_default_id' => 'fake_value',
                        'census_year' => 'fake_value',
                        'city' => 'fake_value',
                        'country' => 'fake_value',
                        'county' => 'fake_value',
                        'fips' => 'fake_value',
                        'fips_source' => 'fake_value',
                        'is_anchor' => 'fake_value',
                        'latitude' => 'fake_value',
                        'line1' => 'fake_value',
                        'line2' => 'fake_value',
                        'longitude' => 'fake_value',
                        'serviceable' => true,
                        'subdivision' => 'fake_value',
                        'timezone' => 'fake_value',
                        'type' => 'fake_value',
                        'zip' => 'fake_value',
                    ],
                ],
            ],
        ], true);

        $this->assertTrue($account->serviceable_address()->id === 123);
    }
    public function test_get_serviceable_address_address_included_no_addresses()
    {
        $account = new Account([
            'id' => 'fake_value',
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'account_status_id' => 'fake_value',
            'account_type_id' => 'fake_value',
            'activation_date' => 'fake_value',
            'activation_time' => 'fake_value',
            'company_id' => 'fake_value',
            'data_usage_percentage' => 'fake_value',
            'is_delinquent' => 'fake_value',
            'name' => 'fake_value',
            'next_bill_date' => 'fake_value',
            'next_recurring_charge_amount' => 'fake_value',
            'parent_account_id' => 'fake_value',
            'addresses' => [
                'entities' => [
                ],
            ],
        ], true);

        $this->assertTrue($account->serviceable_address()?->id === null);
    }

    public function test_fail_get_serviceable_address_no_exist()
    {
        $account = new Account([
            'id' => 'fake_value',
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'account_status_id' => 'fake_value',
            'account_type_id' => 'fake_value',
            'activation_date' => 'fake_value',
            'activation_time' => 'fake_value',
            'company_id' => 'fake_value',
            'data_usage_percentage' => 'fake_value',
            'is_delinquent' => 'fake_value',
            'name' => 'fake_value',
            'next_bill_date' => 'fake_value',
            'next_recurring_charge_amount' => 'fake_value',
            'parent_account_id' => 'fake_value',
        ]);

        $this->expectException(\Exception::class);

        $account->serviceable_address();

    }
}
