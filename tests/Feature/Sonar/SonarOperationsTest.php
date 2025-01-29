<?php

namespace tests\Feature\Sonar;

use Kengineering\Sonar\Objects\AccountStatus;
use Kengineering\Sonar\Operations\Query;
use Kengineering\Sonar\Request;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Client;

class SonarOperationsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Load test environment file
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(dirname(dirname(__DIR__))));
        $dotenv->load();
    }
    public function test_query_get()
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

        $mockClient->method('post')
            ->willReturn($mockResponse);

        $query = new Query(AccountStatus::class, $mockClient);
        $objects = $query->get();

        $this->assertEquals('fake_value', $objects[0]->name);
        $this->assertEquals('fake_value', $objects[0]->color);
        $this->assertEquals('fake_value', $objects[0]->icon);

    }
    public function test_request_batched_get()
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
                'operation_test' => [
                    'entities' => [
                        [
                            'id' => 'fake_value_0',
                            'sonar_unique_id' => 'fake_value_0',
                            'created_at' => 'fake_value_0',
                            'updated_at' => 'fake_value_0',
                            '_version' => 'fake_value_0',
                            'activates_account' => 'fake_value_0',
                            'color' => 'fake_value_0',
                            'icon' => 'fake_value_0',
                            'name' => 'fake_value_0',
                        ],
                    ],
                ],
                'operation_testing' => [
                    'entities' => [
                        [
                            'id' => 'fake_value_1',
                            'sonar_unique_id' => 'fake_value_1',
                            'created_at' => 'fake_value_1',
                            'updated_at' => 'fake_value_1',
                            '_version' => 'fake_value_1',
                            'activates_account' => 'fake_value_1',
                            'color' => 'fake_value_1',
                            'icon' => 'fake_value_1',
                            'name' => 'fake_value_1',
                        ],
                    ],
                ],
            ],
        ];

        $mockBody->method('getContents')
            ->willReturn(json_encode($result));

        $mockResponse->method('getStatusCode')->willReturn(200);
        $mockResponse->method('getBody')->willReturn($mockBody);

        $mockClient->method('post')
            ->willReturn($mockResponse);

        $request = new Request(client: $mockClient);
        $request->addOperations(['test' => AccountStatus::query(), 'testing' => AccountStatus::query()]);

        $results = $request->get();

        $this->assertEquals('fake_value_0', $results['test'][0]->name);
        $this->assertEquals('fake_value_0', $results['test'][0]->color);
        $this->assertEquals('fake_value_0', $results['test'][0]->icon);
        $this->assertEquals('fake_value_1', $results['testing'][0]->name);
        $this->assertEquals('fake_value_1', $results['testing'][0]->color);
        $this->assertEquals('fake_value_1', $results['testing'][0]->icon);
    }

    public function test_request_bad_operation()
    {
        $request = new Request;
        $this->expectException(\Exception::class);
        $request->addOperations(['test' => AccountStatus::query(), 1]);

    }

    public function test_request_batched_mutate()
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

                    $pattern = '/mutation request\( \$[a-z]+: CreateAccountStatusMutationInput \) {operation_0: createAccountStatus\(input: \$[a-z]+ \) {id sonar_unique_id created_at updated_at _version activates_account color icon name} }/';

                    if (!preg_match($pattern, $options['json']['query'])) {
                        return false;
                    }

                    foreach ($options['json']['variables'] as $variable) {
                        if (
                            $variable !== [
                                'name' => 'fake_value_1',
                                'activates_account' => 'fake_value_1',
                                'color' => 'fake_value_1',
                                'icon' => 'fake_value_1',
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
            'id' => 'fake_value_1',
            'sonar_unique_id' => 'fake_value_1',
            'created_at' => 'fake_value_1',
            'updated_at' => 'fake_value_1',
            '_version' => 'fake_value_1',
            'activates_account' => 'fake_value_1',
            'color' => 'fake_value_1',
            'icon' => 'fake_value_1',
            'name' => 'fake_value_1',
        ]);

        $r = new Request('mutation', [], $mockClient);

        $r->addOperations([$as]);

        $r->mutate();

    }
}
