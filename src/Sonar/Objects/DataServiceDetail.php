<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $billing_frequency
 * @property int $download_speed_kilobits_per_second
 * @property int $service_id
 * @property string $technology_code
 * @property string $telrad_global_service_profile_name
 * @property string $upload_speed_kilobits_per_second
 * @property int $usage_based_billing_policy_id
 * @property Service $service
 */
class DataServiceDetail extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'billing_frequency',
        'download_speed_kilobits_per_second',
        'service_id',
        'technology_code',
        'telrad_global_service_profile_name',
        'upload_speed_kilobits_per_second',
        'usage_based_billing_policy_id',
    ];

    const RELATED_OBJECTS = [
        'service' => 'one',
    ];
}
