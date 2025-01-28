<?php

namespace tests\Unit\Sonar\ObjectTests;

use Kengineering\Sonar\Objects\Account;
use Kengineering\Sonar\Objects\AccountStatus;
use Kengineering\Sonar\Objects\AccountType;
use Kengineering\Sonar\Objects\Address;
use Kengineering\Sonar\Objects\SonarObject;
use Kengineering\Sonar\Operations\Mutation;
use Kengineering\Sonar\Operations\Query;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;

class BasicObjectTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Load test environment file
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(dirname(dirname(dirname(__DIR__)))));
        $dotenv->load();
    }
    public function test_basic_construction()
    {
        $as = new AccountStatus([
            'id' => 'fake_value',
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'activates_account' => 'fake_value',
            'color' => 'fake_value',
            'icon' => 'fake_value',
            'name' => 'fake_value',
        ]);

        $this->assertEquals('fake_value', $as->name);
        $this->assertEquals('fake_value', $as->color);
        $this->assertEquals('fake_value', $as->icon);
    }

    public function test_complex_construction_many_relationship()
    {
        $as = new AccountStatus([
            'id' => 'fake_value',
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'activates_account' => 'fake_value',
            'color' => 'fake_value',
            'icon' => 'fake_value',
            'name' => 'fake_value',
            'accounts' => [
                'entities' => [
                    [
                        'id' => 'account_fake_value',
                        'sonar_unique_id' => 'account_fake_value',
                        'created_at' => 'account_fake_value',
                        'updated_at' => 'account_fake_value',
                        '_version' => 'account_fake_value',
                        'account_status_id' => 'account_fake_value',
                        'account_type_id' => 'account_fake_value',
                        'activation_date' => 'account_fake_value',
                        'activation_time' => 'account_fake_value',
                        'company_id' => 'account_fake_value',
                        'data_usage_percentage' => 'account_fake_value',
                        'is_delinquent' => 'account_fake_value',
                        'name' => 'account_fake_value',
                        'next_bill_date' => 'account_fake_value',
                        'next_recurring_charge_amount' => 'account_fake_value',
                        'parent_account_id' => 'account_fake_value',
                    ],
                ],
            ],
        ]);
        $this->assertEquals('account_fake_value', $as->accounts[0]->name);
        $this->assertEquals('account_fake_value', $as->accounts[0]->is_delinquent);
        $this->assertEquals('account_fake_value', $as->accounts[0]->account_type_id);
    }

    public function test_owned_by_relationship()
    {
        $ad = new Address([
            'id' => 'fake_value',
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
            'serviceable' => 'fake_value',
            'subdivision' => 'fake_value',
            'timezone' => 'fake_value',
            'type' => 'fake_value',
            'zip' => 'fake_value',
            'addressable' => [
                '__typename' => 'Account',
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
                'name' => 'diferent_fake_value',
                'next_bill_date' => 'fake_value',
                'next_recurring_charge_amount' => 'fake_value',
                'parent_account_id' => 'fake_value',
            ],
        ]);
        $this->assertEquals('diferent_fake_value', $ad->account->name);
    }

    public function test_complex_construction_one_relationship()
    {
        $as = new Account([
            'id' => 'account_fake_value',
            'sonar_unique_id' => 'account_fake_value',
            'created_at' => 'account_fake_value',
            'updated_at' => 'account_fake_value',
            '_version' => 'account_fake_value',
            'account_status_id' => 'account_fake_value',
            'account_type_id' => 'account_fake_value',
            'activation_date' => 'account_fake_value',
            'activation_time' => 'account_fake_value',
            'company_id' => 'account_fake_value',
            'data_usage_percentage' => 'account_fake_value',
            'is_delinquent' => 'account_fake_value',
            'name' => 'account_fake_value',
            'next_bill_date' => 'account_fake_value',
            'next_recurring_charge_amount' => 'account_fake_value',
            'parent_account_id' => 'account_fake_value',
            'account_status' => [
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
        ]);
        $this->assertEquals('fake_value', $as->account_status->name);
        $this->assertEquals('fake_value', $as->account_status->activates_account);
        $this->assertEquals('fake_value', $as->account_status->icon);
    }

    public function test_setting_property_values()
    {
        $as = new AccountStatus([
            'id' => 12321,
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'activates_account' => 'fake_value',
            'color' => 'fake_value',
            'icon' => 'fake_value',
            'name' => 'fake_value',
        ]);

        $as->name = 'test';

        $this->assertEquals($as->name, 'test');
    }

    public function test_to_array_function()
    {
        $as = new AccountStatus([
            'id' => 12321,
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'activates_account' => 'fake_value',
            'color' => 'fake_value',
            'icon' => 'fake_value',
            'name' => 'fake_value',
        ]);

        $this->assertSame($as->toArray(), [
            'id' => 12321,
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'activates_account' => 'fake_value',
            'color' => 'fake_value',
            'icon' => 'fake_value',
            'name' => 'fake_value',
        ]);
    }

    public function test_query()
    {
        $this->assertEquals(AccountStatus::query(), new Query(AccountStatus::class));
    }

    public function test_mutate()
    {

        $as = new AccountStatus([
            'id' => 12321,
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'activates_account' => 'fake_value',
            'color' => 'fake_value',
            'icon' => 'fake_value',
            'name' => 'fake_value',
        ]);
        $this->assertEquals($as->mutation('create'), new Mutation($as, 'create'));
    }

    public function test_batch()
    {

        $as = new AccountStatus([
            'id' => 12321,
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'activates_account' => 'fake_value',
            'color' => 'fake_value',
            'icon' => 'fake_value',
            'name' => 'fake_value',
        ], true);
        $this->assertEquals($as->batch(), new Mutation($as, 'update'));
    }

    public function test_batch_update()
    {

        $as = new AccountStatus([
            'id' => 'fake_value_0',
            'sonar_unique_id' => 'fake_value_0',
            'created_at' => 'fake_value_0',
            'updated_at' => 'fake_value_0',
            '_version' => 'fake_value_0',
            'activates_account' => 'fake_value_0',
            'color' => 'fake_value_0',
            'icon' => 'fake_value_0',
            'name' => 'fake_value_0',
        ], true);

        $query = $as->save(true);
        $this->assertEquals($query, new Mutation($as, 'update'));

    }

    public function test_batch_create()
    {

        $as = new AccountStatus([
            'id' => 'fake_value_0',
            'sonar_unique_id' => 'fake_value_0',
            'created_at' => 'fake_value_0',
            'updated_at' => 'fake_value_0',
            '_version' => 'fake_value_0',
            'activates_account' => 'fake_value_0',
            'color' => 'fake_value_0',
            'icon' => 'fake_value_0',
            'name' => 'fake_value_0',
        ], false);

        $query = $as->save(true);
        $this->assertEquals($query, new Mutation($as, 'create'));

    }

    public function test_batch_delete()
    {

        $as = new AccountStatus([
            'id' => 'fake_value_0',
            'sonar_unique_id' => 'fake_value_0',
            'created_at' => 'fake_value_0',
            'updated_at' => 'fake_value_0',
            '_version' => 'fake_value_0',
            'activates_account' => 'fake_value_0',
            'color' => 'fake_value_0',
            'icon' => 'fake_value_0',
            'name' => 'fake_value_0',
        ], true);

        $query = $as->delete(true);
        $this->assertEquals($query, new Mutation($as, 'delete'));

    }

    public function test_relationship()
    {
        $this->assertEquals(Account::object_relationship(AccountStatus::class), 'one');
        $this->expectException(\Exception::class);
        AccountType::object_relationship(AccountStatus::class);
    }

    public function test_mutation_name()
    {
        $so = new SonarObject([
            'id' => 'fake',
            'sonar_unique_id' => 'fake',
            'created_at' => 'fake',
            'updated_at' => 'fake',
            '_version' => 'fake',
        ]);
        $this->assertEquals($so->get_mutation_name('create'), 'createSonarObject');
    }

    public function test_mutation_input_name()
    {
        $so = new SonarObject([
            'id' => 'fake',
            'sonar_unique_id' => 'fake',
            'created_at' => 'fake',
            'updated_at' => 'fake',
            '_version' => 'fake',
        ]);
        $this->assertEquals($so->get_mutation_input_name('create'), 'CreateSonarObjectMutationInput');
    }

    public function test_cant_refresh_object()
    {
        $so = new SonarObject([
            'id' => 'fake',
            'sonar_unique_id' => 'fake',
            'created_at' => 'fake',
            'updated_at' => 'fake',
            '_version' => 'fake',
        ]);
        $this->expectException(\Exception::class);
        $so->refresh_object([]);
    }

    public function test_update_object()
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
                    'entities' => [
                        [
                            'id' => 12321,
                            'sonar_unique_id' => 'fake_value',
                            'created_at' => 'fake_value',
                            'updated_at' => 'fake_value',
                            '_version' => 'fake_value',
                            'activates_account' => 'fake_value',
                            'color' => 'fake_value',
                            'icon' => 'fake_value',
                            'name' => 'fake_value',
                            'accounts' => [
                                'entities' => [
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
                                ],
                            ],
                        ],
                    ],
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

                    $pattern = '/query request\( \$[a-z]{26}: \[Search\]  \$[a-z]{26}: Paginator \) {operation_0: account_statuses\(search: \$[a-z]{26} paginator: \$[a-z]{26} \) { entities {id sonar_unique_id created_at updated_at _version activates_account color icon name accounts { entities {id sonar_unique_id created_at updated_at _version account_status_id account_type_id activation_date activation_time company_id data_usage_percentage is_delinquent name next_bill_date next_recurring_charge_amount parent_account_id}}}} }/';



                    if (!preg_match($pattern, $options['json']['query'])) {
                        return false;
                    }

                    foreach ($options['json']['variables'] as $variable) {
                        if (
                            $variable !== [
                                'page' => 1,
                                'records_per_page' => 100,
                            ] && $variable !== [
                                [
                                    'integer_fields' => [
                                        [
                                            'attribute' => 'id',
                                            'search_value' => 12321,
                                            'operator' => 'EQ'
                                        ]
                                    ]
                                ]
                            ]
                        ) {
                            return false;
                        }
                    }

                    return true;
                })
            )
            ->willReturn($mockResponse);


        $so = new AccountStatus([
            'id' => 12321,
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'activates_account' => 'fake_value',
            'color' => 'fake_value',
            'icon' => 'fake_value',
            'name' => 'fake_value',
        ], true, $mockClient);

        $so->refresh_object([Account::class]);
    }
}
