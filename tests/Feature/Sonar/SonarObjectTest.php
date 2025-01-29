<?php

namespace tests\Feature\ApiClients\Sonar;

use Kengineering\Sonar\Objects\AccountStatus;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Client;
use Kengineering\Sonar\Objects\Account;
use Kengineering\Sonar\Objects\AccountService;

class SonarObjectTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Load test environment file
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(dirname(dirname(__DIR__))));
        $dotenv->load();
    }
    public function test_create()
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

                    $pattern = '/mutation request\( \$[a-z]{26}: CreateAccountStatusMutationInput \) {operation_0: createAccountStatus\(input: \$[a-z]{26} \) {id sonar_unique_id created_at updated_at _version activates_account color icon name} }/';

                    if (!preg_match($pattern, $options['json']['query'])) {
                        return false;
                    }

                    foreach ($options['json']['variables'] as $variable) {
                        if (
                            $variable !== [
                                'name' => 'fake_value_0',
                                'activates_account' => 'fake_value_0',
                                'color' => 'fake_value_0',
                                'icon' => 'fake_value_0',
                            ]
                        ) {
                            return false;
                        }
                    }

                    return true;
                })
            )
            ->willReturn($mockResponse);

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
        ], false, $mockClient);

        $as->save();
        $this->assertEquals($as?->id, 12321);

    }
    public function test_update()
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

                    $pattern = '/mutation request\( \$[a-z]{26}: UpdateAccountStatusMutationInput  \$[a-z]{26}: Int64Bit! \) {operation_0: updateAccountStatus\(input: \$[a-z]{26} id: \$[a-z]{26} \) {id sonar_unique_id created_at updated_at _version activates_account color icon name} }/';

                    if (!preg_match($pattern, $options['json']['query'])) {
                        return false;
                    }

                    foreach ($options['json']['variables'] as $variable) {
                        if (
                            $variable !== [
                                'name' => 'fake_value_0',
                                'activates_account' => 'fake_value_0',
                                'color' => 'fake_value_0',
                                'icon' => 'fake_value_0',
                            ] && $variable !== 'fake_value_0'
                        ) {
                            return false;
                        }
                    }

                    return true;
                })
            )
            ->willReturn($mockResponse);

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
        ], true, $mockClient);

        $as->save();
    }



    public function test_get()
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
                    $pattern = '/query request\( \$[a-z]{26}: Paginator \) {operation_0: account_statuses\(paginator: \$[a-z]{26} \) { entities {id sonar_unique_id created_at updated_at _version activates_account color icon name}} }/';



                    if (!preg_match($pattern, $options['json']['query'])) {
                        return false;
                    }

                    return true;
                })
            )
            ->willReturn($mockResponse);


        $results = AccountStatus::get($mockClient);

        $this->assertEquals('fake_value', $results[0]->name);

    }

    public function test_first()
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
                    $pattern = '/query request\( \$[a-z]{26}: Paginator \) {operation_0: account_statuses\(paginator: \$[a-z]{26} \) { entities {id sonar_unique_id created_at updated_at _version activates_account color icon name}} }/';



                    if (!preg_match($pattern, $options['json']['query'])) {
                        return false;
                    }

                    return true;
                })
            )
            ->willReturn($mockResponse);


        $result = AccountStatus::first($mockClient);

        $this->assertEquals('fake_value', $result->name);

    }

    public function test_first_or_fail_first()
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
                    $pattern = '/query request\( \$[a-z]{26}: Paginator \) {operation_0: account_statuses\(paginator: \$[a-z]{26} \) { entities {id sonar_unique_id created_at updated_at _version activates_account color icon name}} }/';



                    if (!preg_match($pattern, $options['json']['query'])) {
                        return false;
                    }

                    return true;
                })
            )
            ->willReturn($mockResponse);


        $result = AccountStatus::firstOrFail($mockClient);

        $this->assertEquals('fake_value', $result->name);

    }

    public function test_first_or_fail_fail()
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
                    $pattern = '/query request\( \$[a-z]{26}: Paginator \) {operation_0: account_statuses\(paginator: \$[a-z]{26} \) { entities {id sonar_unique_id created_at updated_at _version activates_account color icon name}} }/';



                    if (!preg_match($pattern, $options['json']['query'])) {
                        return false;
                    }

                    return true;
                })
            )
            ->willReturn($mockResponse);
        $this->expectException(\Exception::class);


        $result = AccountStatus::firstOrFail($mockClient);

        $this->assertEquals('fake_value', $result->name);
    }

    public function test_delete()
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
                    $pattern = '/mutation request\( \$[a-z]{26}: Int64Bit! \) {operation_0: deleteAccountStatus\(id: \$[a-z]{26} \) {success message} }/';



                    if (!preg_match($pattern, $options['json']['query'])) {
                        return false;
                    }

                    foreach ($options['json']['variables'] as $variable) {
                        if (
                            $variable !== 12321
                        ) {
                            return false;
                        }
                    }

                    return true;
                })
            )
            ->willReturn($mockResponse);

        $as = new AccountStatus([
            'id' => 12321,
            'sonar_unique_id' => 'fake_value_0',
            'created_at' => 'fake_value_0',
            'updated_at' => 'fake_value_0',
            '_version' => 'fake_value_0',
            'activates_account' => 'fake_value_0',
            'color' => 'fake_value_0',
            'icon' => 'fake_value_0',
            'name' => 'fake_value_0',
        ], true, $mockClient);

        $as->delete();
    }

    public function test_refresh_object_fail()
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
                    'entities' => []
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
                                [
                                    'integer_fields' =>
                                        [
                                            [
                                                'attribute' => 'id',
                                                'search_value' => 12321,
                                                'operator' => 'EQ'
                                            ]
                                        ]
                                ]
                            ] && $variable !== [
                                'page' => 1,
                                'records_per_page' => 100
                            ]
                        ) {
                            return false;
                        }
                    }

                    return true;
                })
            )
            ->willReturn($mockResponse);

        $as = new AccountStatus([
            'id' => 12321,
            'sonar_unique_id' => 'fake_value_0',
            'created_at' => 'fake_value_0',
            'updated_at' => 'fake_value_0',
            '_version' => 'fake_value_0',
            'activates_account' => 'fake_value_0',
            'color' => 'fake_value_0',
            'icon' => 'fake_value_0',
            'name' => 'fake_value_0',
        ], true, $mockClient);

        $this->expectException(\Exception::class);

        $as->refresh_object([Account::class]);
    }


    public function test_delete_with_input()
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
                    $pattern = '/mutation request\( \$[a-z]{26}: Int64Bit!  \$[a-z]{26}: DeleteAccountServiceMutationInput \) {operation_0: deleteAccountService\(id: \$[a-z]{26} input: \$[a-z]{26} \) {success message} }/';



                    if (!preg_match($pattern, $options['json']['query'])) {
                        return false;
                    }

                    foreach ($options['json']['variables'] as $variable) {
                        if (
                            $variable !== 12321 && $variable !== ['insert_var' => 'test']
                        ) {
                            return false;
                        }
                    }

                    return true;
                })
            )
            ->willReturn($mockResponse);

        $as = new AccountService([
            'id' => 12321,
            'sonar_unique_id' => 'fake_value',
            'created_at' => 'fake_value',
            'updated_at' => 'fake_value',
            '_version' => 'fake_value',
            'account_id' => 'fake_value',
            'addition_prorate_date' => 'fake_value',
            'data_usage_last_calculated_date' => 'fake_value',
            'name_override' => 'fake_value',
            'next_bill_date' => 'fake_value',
            'number_of_times_billed' => 'fake_value',
            'package_id' => 'fake_value',
            'price_override' => 'fake_value',
            'price_override_reason' => 'fake_value',
            'quantity' => 'fake_value',
            'service_id' => 'fake_value',
            'unique_package_relationship_id' => 'fake_value',
        ], true, $mockClient);

        $as->delete(false, ['insert_var' => 'test']);
    }
}
