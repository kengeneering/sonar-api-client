<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $sonar_unique_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $_version
 * @property int $company_id
 * @property bool $enabled
 * @property string $name
 * @property bool $rollup_services
 * @property array<PackageService> $package_services
 * @property array<Account> $accounts
 */
class Package extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'company_id',
        'enabled',
        'name',
        'rollup_services',
    ];

    const RELATED_OBJECTS = [
        'package_service' => 'many',
        'account' => 'many',
    ];
}
