<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property string $message
 * @property int $noteable_id
 * @property string $noteable_type
 * @property int $user_id
 * @property string $priority
 */
class Note extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'message',
        'noteable_id',
        'noteable_type',
        'priority',
        'user_id',
    ];
}
