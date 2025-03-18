<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property string $current
 * @property bool $legacy
 * @property string $legacy_title
 * @property string $level
 * @property int $loggable_id
 * @property string $loggable_type
 * @property int $logged_entity_id
 * @property string $logged_entity_type
 * @property string $message
 * @property string $previous
 * @property string $relation_data
 * @property string $type
 * @property int $user_id
 */
class Log extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'current',
        'legacy',
        'legacy_title',
        'level',
        'loggable_id',
        'loggable_type',
        'logged_entity_id',
        'logged_entity_type',
        'message',
        'previous',
        'relation_data',
        'type',
        'user_id',
    ];

    const RELATED_OBJECTS = [
        'user' => 'one',
    ];

    public function previousArray() {
        return $this->parseStringAsJson('previous');
    }

    public function currentArray() {
        return $this->parseStringAsJson('current');
    }

    public function relationArray() {
        return $this->parseStringAsJson('relation_data');
    }

    private function parseStringAsJson(string $property) {
        if (is_null($this->$property)) {
            return null;
        }
        return json_decode($this->$property);
    }
}
