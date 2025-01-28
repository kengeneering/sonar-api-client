<?php

namespace tests\Unit\Sonar\GraphqlTests;

use Kengineering\Sonar\Graphql\Query;
use Kengineering\Sonar\Graphql\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_something()
    {
        $this->assertTrue(true);
    }

    public function test_basic_consruction()
    {
        $query = new Query('test_name', ['test0', 'test1', 'test2', 'test3']);

        $request = new Request('query', [$query]);

        $this->assertEquals('query request {operation_0: test_name {test0 test1 test2 test3} }', $request->buildRequest());
    }

    public function test_adding_operations()
    {
        $query = new Query('test_name', ['test0', 'test1', 'test2', 'test3']);

        $request = new Request('query', [$query]);

        $request->addOperation($query);
        $request->addOperations([$query, $query]);

        $this->assertEquals('query request {operation_0: test_name {test0 test1 test2 test3}operation_1: test_name {test0 test1 test2 test3}operation_2: test_name {test0 test1 test2 test3}operation_3: test_name {test0 test1 test2 test3} }', $request->buildRequest());
        $request->addOperations([$query, $query]);

    }

    public function test_named_operations()
    {
        $query = new Query('test_name', ['test0', 'test1', 'test2', 'test3']);

        $request = new Request('query', ['name' => $query]);

        $request->addOperation($query, 'different_name');

        $this->assertEquals('query request {operation_name: test_name {test0 test1 test2 test3}operation_different_name: test_name {test0 test1 test2 test3} }', $request->buildRequest());
    }

    public function test_invalid_named_operations()
    {
        $query = new Query('test_name', ['test0', 'test1', 'test2', 'test3']);

        $request = new Request('query', ['name' => $query]);

        $this->expectException(\InvalidArgumentException::class);

        $request->addOperation($query, 'name');
    }

    public function test_invalid_named_request()
    {
        $query = new Query('test_name', ['test0', 'test1', 'test2', 'test3']);

        $this->expectException(\InvalidArgumentException::class);

        $request = new Request('not_a_query', [$query]);
    }

    public function test_()
    {
        $request = new Request('query');
        $this->expectException(\InvalidArgumentException::class);
        $request->rawQuery('test', []);
    }
}
