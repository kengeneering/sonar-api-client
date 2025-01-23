<?php

namespace Kengineering\Tests\Unit\Sonar;

use Kengineering\Sonar\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function test_invalid_mutate_for_type()
    {
        $request = new Request('query');
        $this->expectException(\Exception::class);
        $request->mutate();
    }

    public function test_invalid_get_for_type()
    {
        $request = new Request('mutation');
        $this->expectException(\Exception::class);
        $request->get();
    }
}
