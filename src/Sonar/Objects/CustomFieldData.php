<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $custom_field_id
 * @property int $customfielddataable_id
 * @property string $customfielddataable_type
 * @property string $value
 * @property CustomField $custom_field
 */
class CustomFieldData extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version', 'custom_field_id',
        'customfielddataable_id',
        'customfielddataable_type',
        'value',
    ];

    const RELATED_OBJECTS = [
        'custom_field' => 'one',
    ];

    const OBJECT_MULTIPLE_NAME = 'custom_field_data';
}
