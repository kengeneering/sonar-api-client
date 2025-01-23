<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property bool $completed_setup
 * @property string $email_address
 * @property bool $enabled
 * @property bool $is_sonar_staff
 * @property string $language
 * @property string $mobile_number
 * @property string $name
 * @property string $public_name
 * @property int $role_id
 * @property bool $super_admin
 * @property string $username
 * @property ?array<InventoryItem> $inventory_items
 */
class User extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'completed_setup',
        'email_address',
        'enabled',
        'is_sonar_staff',
        'language',
        'mobile_number',
        'name',
        'public_name',
        'role_id',
        'super_admin',
        'username',
    ];

    const RELATED_OBJECTS = [
        'inventory_item' => 'many',
    ];
}
