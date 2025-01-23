<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $sonar_unique_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $_version
 * @property int $package_id
 * @property int $quantity
 * @property int $service_id
 * @property array<Package> $packages
 * @property array<Service> $services
 */
class PackageService extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'package_id',
        'quantity',
        'service_id',
    ];

    const RELATED_OBJECTS = [
        'package' => 'many',
        'service' => 'many',
    ];
}
