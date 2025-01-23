<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property string $sonar_unique_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $_version
 * @property int $amount
 * @property string $application
 * @property int $company_id
 * @property bool $display_if_zero
 * @property bool $enabled
 * @property int $general_ledger_code_id
 * @property string $name
 * @property int $reverse_tax_definition_id
 * @property int $tax_definition_id
 * @property int $type
 * @property array<PackageService> $package_services
 */
class Service extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'amount',
        'application',
        'company_id',
        'display_if_zero',
        'enabled',
        'general_ledger_code_id',
        'name',
        'reverse_tax_definition_id',
        'tax_definition_id',
        'type',
    ];

    const RELATED_OBJECTS = [
        'package_service' => 'many',
    ];
}
