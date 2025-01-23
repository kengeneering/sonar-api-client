<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $contactable_id
 * @property string $contactable_type
 * @property string $email_address
 * @property string $language
 * @property bool $marketing_opt_in
 * @property string $name
 * @property bool $primary
 * @property string $role
 * @property string $username
 */
class Contact extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'contactable_id',
        'contactable_type',
        'email_address',
        'language',
        'marketing_opt_in',
        'name',
        'primary',
        'role',
        'username',
    ];

    const RELATED_OBJECTS = [
        'phone_number' => 'many',
    ];
}
