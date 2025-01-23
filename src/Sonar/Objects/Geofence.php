<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $name
 * @property array<Polygon> $polygons
 */
class Geofence extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'name',
    ];

    const RELATED_OBJECTS = [
        'polygon' => 'many',
    ];
}
