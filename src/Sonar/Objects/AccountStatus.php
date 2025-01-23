<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property string $created_at
 * @property string $updated_at
 * @property string $_version
 * @property bool $activates_account
 * @property string $color
 * @property string $icon
 * @property string $name
 * @property array<Account> $accounts
 */
class AccountStatus extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'activates_account',
        'color',
        'icon',
        'name',
    ];

    const RELATED_OBJECTS = [
        'account' => 'many',
    ];

    const CREATE_PROPERTIES = [
        'name',
        'activates_account',
        'color',
        'icon',
        'note',
    ];

    const UPDATE_PROPERTIES = [
        'name',
        'activates_account',
        'color',
        'icon',
        'note',
    ];

    const OBJECT_MULTIPLE_NAME = 'account_statuses';
}
