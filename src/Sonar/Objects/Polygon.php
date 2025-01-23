<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property array<Vertex> $vertexes
 */
class Polygon extends SonarObject
{
    const RELATED_OBJECTS = [
        'vertex' => 'many',
    ];
}
