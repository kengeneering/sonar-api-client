<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property string $name
 * @property bool $sms_capable
 */
class PhoneNumberType extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'name',
        'sms_capable',
    ];

    const RELATED_OBJECTS = [
        'phone_number' => 'many',
    ];
}
