<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $anchor_subsidy
 * @property int $billing_default_id
 * @property string $name_override
 * @property int $price
 * @property int $service_id
 * @property BillingDefault $billing_default
 * @property Service $service
 */
class BillingService extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version', 'anchor_subsidy',
        'billing_default_id',
        'name_override',
        'price',
        'service_id',
    ];

    const RELATED_OBJECTS = [
        'billing_default' => 'one',
        'service' => 'one',
    ];
}
