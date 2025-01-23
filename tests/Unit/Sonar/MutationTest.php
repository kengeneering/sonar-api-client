<?php

namespace tests\Unit\ApiClients\Sonar;

use Kengineering\Sonar\Objects\AccountStatus;
use Kengineering\Sonar\Operations\Mutation;
use PHPUnit\Framework\TestCase;

class MutationTest extends TestCase
{
    public function test_mutation_invalid_type()
    {
        $this->expectException(\InvalidArgumentException::class);
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
        new Mutation($as, 'not_a_valid_option');
    }
}
