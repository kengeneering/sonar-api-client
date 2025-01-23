<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property string $color
 * @property string $icon
 * @property int $invoice_message_id
 * @property string $name
 * @property string $type
 */
class AccountType extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'color',
        'icon',
        'invoice_message_id',
        'name',
        'type',
    ];

    const RELATED_OBJECTS = [
        'account' => 'many',
    ];
}
