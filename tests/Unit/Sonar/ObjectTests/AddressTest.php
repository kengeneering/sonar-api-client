<?php

namespace tests\Unit\Sonar\ObjectTests;

use Kengineering\Sonar\Objects\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function test_mutation_name_and_input_name()
    {
        $address = new Address([
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
            'type' => 'mailing',
            'zip' => 'fake_value',
        ]);
        $this->assertEquals($address->get_mutation_name('create'), 'CreateMailingAddress');
        $this->assertEquals($address->get_mutation_input_name('create'), 'CreateMailingAddressMutationInput');
    }
}
