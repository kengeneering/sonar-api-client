<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property string $entity_type
 * @property ?array<string> $enum_options
 * @property string $name
 * @property bool $required
 * @property string $type
 * @property bool $unique
 * @property array<CustomFieldData> $custom_field_data
 */
class CustomField extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'entity_type',
        'enum_options',
        'name',
        'required',
        'type',
        'unique',
    ];

    const RELATED_OBJECTS = [
        'custom_field_data' => 'many',
    ];
}
