<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property float $latitude
 * @property float $longitude
 */
class Vertex extends SonarObject
{
    const PROPERTIES = [
        'latitude',
        'longitude',
    ];

    const OBJECT_MULTIPLE_NAME = 'vertexes';
}
