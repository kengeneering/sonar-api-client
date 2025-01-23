<?php

namespace tests\Unit\Sonar\GraphqlTests;

use Kengineering\Sonar\Graphql\Query;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    public function test_aliasing()
    {
        $query = new Query('test_name', ['test0', 'test1', 'test2', 'test3'], 'test_alias');

        $this->assertEquals('test_alias: test_name {test0 test1 test2 test3}', (string) $query);

        $same_query = $query->setAlias('different_alias');

        $this->assertEquals($same_query, $query);

        $this->assertEquals('different_alias: test_name {test0 test1 test2 test3}', (string) $query);
    }

    public function test_basic_construction()
    {
        $query = new Query('test_name', ['test0', 'test1', 'test2', 'test3']);

        $this->assertEquals('test_name {test0 test1 test2 test3}', (string) $query);
    }

    public function test_complex_construction()
    {
        $query = new Query('test_name', [
            'test0',
            'test1',
            'test2',
            'test3',
            new Query('inner_query0', [
                'test0',
                'test1',
                'test2',
                'test3',
            ]),
            new Query('inner_query1', [
                'test0',
                'test1',
                'test2',
                'test3',
            ]),
        ]);

        $this->assertEquals('test_name {test0 test1 test2 test3 inner_query0 {test0 test1 test2 test3} inner_query1 {test0 test1 test2 test3}}', (string) $query);
    }

    public function test_adding_variables()
    {
        $query = new Query('test_name', ['test0', 'test1', 'test2', 'test3']);
        $query->addVariable(['test' => 'more_test'], 'int');
        $query->addVariable(['different_test' => ['data' => 'different_more_test']], 'string', true);

        $expected_variables = [
            'test' => [
                'data' => 'more_test',
                'type' => 'int',
                'required' => false,
            ],
            'different_test' => [
                'data' => ['data' => 'different_more_test'],
                'type' => 'string',
                'required' => true,
            ],
        ];

        $variables = $query->getVariables();
        $ordered = 'abcdefghijklmnopqrstuvwxyz';

        foreach ($expected_variables as $i => $expected_variable) {
            $this->assertSame($expected_variable['data'], $variables[$i]['data']);
            $this->assertSame($expected_variable['type'], $variables[$i]['type']);
            $this->assertSame($expected_variable['required'], $variables[$i]['required']);

            $this->assertNotSame($ordered, $variables[$i]['name']);
            $sortedScrambled = str_split($variables[$i]['name']);
            sort($sortedScrambled);
            $sortedScrambled = implode('', $sortedScrambled);
            $this->assertSame($ordered, $sortedScrambled);
        }
        $this->assertMatchesRegularExpression(
            '/test_name\(test: \$[a-z]{26} different_test: \$[a-z]{26} \) {test0 test1 test2 test3}/',
            (string) $query
        );
    }

    public function test_basic_build()
    {
        $query = new Query('test_name', ['test0', 'test1', 'test2', 'test3']);

        $this->assertSame($query, $query->build());

    }
}
