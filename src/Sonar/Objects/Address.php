<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $address_status_id
 * @property int $addressable_id
 * @property string $addressable_type
 * @property int $anchor_address_id
 * @property int $attainable_download_speed
 * @property int $attainable_upload_speed
 * @property string $avalara_pcode
 * @property int $billing_default_id
 * @property string $census_year
 * @property string $city
 * @property string $country
 * @property string $county
 * @property int $fips
 * @property int $fips_source
 * @property bool $is_anchor
 * @property float $latitude
 * @property string $line1
 * @property string $line2
 * @property float $longitude
 * @property bool $serviceable
 * @property string $subdivision
 * @property string $timezone
 * @property string $type
 * @property int $zip
 * @property ?Account $account
 * @property ?array<CustomFieldData> $custom_field_data
 */
class Address extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'address_status_id',
        'addressable_id',
        'addressable_type',
        'anchor_address_id',
        'attainable_download_speed',
        'attainable_upload_speed',
        'avalara_pcode',
        'billing_default_id',
        'census_year',
        'city',
        'country',
        'county',
        'fips',
        'fips_source',
        'is_anchor',
        'latitude',
        'line1',
        'line2',
        'longitude',
        'serviceable',
        'subdivision',
        'timezone',
        'type',
        'zip',
    ];

    const RELATED_OBJECTS = [
        'account' => 'owned_by',
        'custom_field_data' => 'many',
    ];

    const OBJECT_MULTIPLE_NAME = 'addresses';

    const OWNED_ACCESS_NAME = 'addressable';

    const CREATE_PROPERTIES = [
        'line1',
        'line2',
        'city',
        'subdivision',
        'zip',
        'country',
        'address_status_id',
    ];

    const UPDATE_PROPERTIES = [
        'name',
        'account_status_id',
        'account_type_id',
        'serviceable_address_id',
        'account_group_ids',
        'company_id',
        'prorate',
        'custom_field_data',
        'unset_custom_field_data',
        'note',
        'files',
        'tasks',
    ];

    public function mutate_function_name(string $mutation_type): string
    {
        $address_type = $this->type ?? 'serviceable';

        return ucfirst($mutation_type).ucfirst($address_type).'Address';
    }

    public function mutate_function_input_name(string $mutation_type): string
    {
        $address_type = $this->type ?? 'serviceable';

        return ucfirst($mutation_type).ucfirst($address_type).'AddressMutationInput';
    }
}
