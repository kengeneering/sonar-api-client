<?php

namespace tests\Feature\ApiClients\Sonar;

use Kengineering\Sonar\Graphql\Query;
use Kengineering\Sonar\Graphql\Request;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Client;

class GraphQlTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Load test environment file
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(dirname(dirname(__DIR__))));
        $dotenv->load();
    }
    public function testRawQuery()
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

        $mockBody->expects($this->once())
            ->method('getContents')
            ->willReturn(json_encode(['data' => ['test' => 'value']]));

        $mockResponse->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($mockBody);

        $mockClient->expects($this->once())
            ->method('post')
            ->with(
                'url',
                $this->callback(function ($options) {
                    return isset($options['json']['query'])
                        && isset($options['headers']['Authorization']);
                })
            )
            ->willReturn($mockResponse);

        $request = new Request();
        $result = $request->rawQuery('query', [], $mockClient);

        $this->assertTrue($result['success']);
        $this->assertEquals(['test' => 'value'], $result['data']);
    }
    public function test_sending_request()
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

        $mockBody->expects($this->once())
            ->method('getContents')
            ->willReturn(json_encode([
                'data' => ['1']
            ]));

        $mockResponse->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($mockBody);

        $expectedData = [
            'query' => 'query request {operation_name: test_name {test0 test1 test2 test3} }',
            'variables' => []
        ];

        $mockClient->expects($this->once())
            ->method('post')
            ->with(
                'url',
                $this->callback(function ($options) use ($expectedData) {
                    return
                        $options['headers']['Content-Type'] === 'application/json' &&
                        $options['headers']['Cache-Control'] === 'no-cache' &&
                        $options['headers']['Authorization'] === 'Bearer key' &&
                        $options['json'] === $expectedData;
                })
            )
            ->willReturn($mockResponse);

        $query = new Query('test_name', ['test0', 'test1', 'test2', 'test3']);
        $request = new Request('query', ['name' => $query], $mockClient);
        $response = $request->sendRequest();

        $this->assertEquals(['1'], $response);
    }

    public function test_sending_request_with_variables()
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

        $mockBody->method('getContents')
            ->willReturn(json_encode(['data' => 1]));

        $mockResponse->method('getStatusCode')->willReturn(200);
        $mockResponse->method('getBody')->willReturn($mockBody);

        $mockClient->expects($this->once())
            ->method('post')
            ->with(
                'url',
                $this->callback(function ($options) {
                    $pattern = '/query request\( \$[a-z]+: name \) {operation_0: test_name\(test: \$[a-z]+ \) {test0 test1 test2 test3} }/';

                    if (!preg_match($pattern, $options['json']['query'])) {
                        return false;
                    }

                    foreach ($options['json']['variables'] as $variable) {
                        if ($variable !== ['name' => 'ken']) {
                            return false;
                        }
                    }

                    return true;
                })
            )
            ->willReturn($mockResponse);

        $query = new Query('test_name', ['test0', 'test1', 'test2', 'test3']);
        $query->addVariable(['test' => ['name' => 'ken']], 'name');
        $request = new Request('query', [$query], $mockClient);
        $response = $request->sendRequest();

        $this->assertEquals(1, $response);
    }
    public function test_sending_request_fail()
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

        $mockBody->method('getContents')
            ->willReturn(json_encode(['errors' => ['tsk tsk tsk']]));

        $mockResponse->method('getStatusCode')->willReturn(500);
        $mockResponse->method('getBody')->willReturn($mockBody);

        $mockClient->expects($this->once())
            ->method('post')
            ->with(
                'url',
                $this->callback(function ($options) {
                    return $options['json'] === [
                        'query' => 'query request {operation_name: test_name {test0 test1 test2 test3} }',
                        'variables' => []
                    ];
                })
            )
            ->willReturn($mockResponse);

        $query = new Query('test_name', ['test0', 'test1', 'test2', 'test3']);
        $request = new Request('query', ['name' => $query], $mockClient);

        $this->expectException(\InvalidArgumentException::class);
        $request->sendRequest();
    }

    public function test_sending_request_errors()
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

        $mockBody->method('getContents')
            ->willReturn(json_encode(['errors' => ['tsk tsk tsk']]));

        $mockResponse->method('getStatusCode')->willReturn(200);
        $mockResponse->method('getBody')->willReturn($mockBody);

        $mockClient->expects($this->once())
            ->method('post')
            ->with(
                'url',
                $this->callback(function ($options) {
                    return $options['json'] === [
                        'query' => 'query request {operation_name: test_name {test0 test1 test2 test3} }',
                        'variables' => []
                    ];
                })
            )
            ->willReturn($mockResponse);

        $query = new Query('test_name', ['test0', 'test1', 'test2', 'test3']);
        $request = new Request('query', ['name' => $query], $mockClient);

        $this->expectException(\InvalidArgumentException::class);
        $request->sendRequest();
    }
}
