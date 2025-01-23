<?php

namespace Kengineering\DataStructures;

class Node
{
    public mixed $value;

    private self $parent;

    /** @var Node[] */
    public array $children = [];

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    public function addChild(Node $child): Node
    {
        $child->parent = $this;
        $this->children[] = $child;

        return $child;
    }

    public function parent(): Node
    {
        return $this->parent;
    }

    /**
     * @return Node[] */
    public function children(): array
    {
        return $this->children;
    }
}
