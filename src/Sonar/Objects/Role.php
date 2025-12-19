<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property array<string> $applied_permissions
 * @property string $name
 */
class Role extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'applied_permissions',
        'name',
    ];

    const RELATED_OBJECTS = [
        'user' => 'many',
    ];
}
