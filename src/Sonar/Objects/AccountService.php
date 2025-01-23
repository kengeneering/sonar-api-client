<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $id
 * @property string $sonar_unique_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $_version
 * @property int $account_id
 * @property string $addition_prorate_date
 * @property string $data_usage_last_calculated_date
 * @property string $name_override
 * @property string $next_bill_date
 * @property int $number_of_times_billed
 * @property int $package_id
 * @property int $price_override
 * @property string $price_override_reason
 * @property int $quantity
 * @property int $service_id
 * @property string $unique_package_relationship_id
 * @property Account $account
 * @property Service $service
 */
class AccountService extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'account_id',
        'addition_prorate_date',
        'data_usage_last_calculated_date',
        'name_override',
        'next_bill_date',
        'number_of_times_billed',
        'package_id',
        'price_override',
        'price_override_reason',
        'quantity',
        'service_id',
        'unique_package_relationship_id',
    ];

    const RELATED_OBJECTS = [
        'service' => 'one',
        'account' => 'one',
    ];
}
