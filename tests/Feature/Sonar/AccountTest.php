<?php

namespace Kengineering\Tests\Feature\Sonar;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Kengineering\Sonar\Objects\Account;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Load test environment file
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(dirname(dirname(__DIR__))));
        $dotenv->load();
    }
    public function test_add_service_non_batched_request()
    {

        $mockClient = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['post'])
            ->getMock();

        $mockResponse = $this->getMockBuilder(Response::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getStatusCode', 'getBody'])
            ->getMock();

        $mockBody = $this->getMockBuilder(Stream::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getContents'])
            ->getMock();


        $result = [
            'data' => [
                'operation_0' => [
                    'id' => 12321,
                ],
            ],
        ];
        $mockBody->method('getContents')
            ->willReturn(json_encode($result));

        $mockResponse->method('getStatusCode')->willReturn(200);
        $mockResponse->method('getBody')->willReturn($mockBody);

        $mockClient->expects($this->once())
            ->method('post')
            ->with(
                'url',
                $this->callback(function ($options) {

                    $pattern = '/mutation request\( \$[a-z]{26}: AddServiceToAccountMutationInput \) {operation_0: addServiceToAccount\(input: \$[a-z]{26} \) {id} }/';

                    if (!preg_match($pattern, $options['json']['query'])) {
                        return false;
                    }

                    foreach ($options['json']['variables'] as $variable) {
                        if (
                            $variable !== [
                                'service_id' => 12321,
                                'account_id' => 'fake',
                                'quantity' => 1,
                            ]
                        ) {
                            return false;
                        }
                    }

                    return true;
                })
            )
            ->willReturn($mockResponse);

        $account = new Account([
            'id' => 'fake',
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
        ], true, $mockClient);


        $account->addService(12321);

    }

    public function test_need_to_collect_addresses()
    {
        $mock = $this->getMockBuilder(Account::class)
            ->setConstructorArgs([
                [
                    'id' => 123,
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
                ],
                true
            ])
            ->onlyMethods(['refresh_object'])
            ->getMock();


        $result = new account(
            [
                'id' => 123,
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
            ],
            true
        );

        $mock->method('refresh_object')->willReturn($result);

        $this->assertEquals($mock->serviceable_address()->id, 123);

    }
}