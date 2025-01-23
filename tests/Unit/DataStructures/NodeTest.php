<?php

namespace Tests\Unit\DataStructures;

use Kengineering\DataStructures\Node;
use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    public function test_accessing_value()
    {
        $node = new Node(1234321);

        $this->assertEquals($node->value, 1234321);
    }

    public function test_set_and_get_children()
    {
        $node = new Node(0);

        $node->addChild(new Node('test_value'));
        $node->addChild(new Node('another_test_value'));

        $expected_values = ['test_value', 'another_test_value'];

        foreach ($node->children() as $i => $child) {
            $this->assertEquals($expected_values[$i], $child->value);
        }
    }

    public function test_set_and_get_parent()
    {
        $node = new Node(0);

        $node->addChild(new Node('0'));
        $node->addChild(new Node('1'));

        foreach ($node->children() as $i => $child) {
            $this->assertEquals($node, $child->parent());
        }

    }
}
