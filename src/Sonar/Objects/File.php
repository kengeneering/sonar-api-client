<?php

namespace Kengineering\Sonar\Objects;

use Kengineering\Sonar\Graphql\Query;
use Kengineering\Sonar\Operations\Mutation;
use Kengineering\Sonar\Traits\CanHaveNotes;

/**
 * @property string $description
 * A human readable description.
 *
 * @property int $file_size_in_bytes
 * The file size, in bytes.
 *
 * @property int $fileable_id
 * The ID of the entity that owns this file.
 *
 * @property string $fileable_type
 * The type of entity that owns this file.
 *
 * @property string $filename
 * The file name.
 *
 * @property string $mime_type
 * The MIME type of the file.
 *
 * @property bool $primary_image
 * An image file may be set to the primary image. This will be used as the displayed image for the object that this file is associated to throughout Sonar.
 *
 * @property int $user_id
 */
class File extends SonarObject
{
    use CanHaveNotes;

    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'description',
        'file_size_in_bytes',
        'fileable_id',
        'fileable_type',
        'filename',
        'mime_type',
        'primary_image',
        'user_id',
    ];

    const RELATED_OBJECTS = [
        'account' => 'owned_by',
    ];

    const UPDATE_PROPERTIES = [
        'description',
        'primary_image',
    ];

    public function assignFileToEntity($fileable_type, $fileable_id, bool $batch_request = false): Mutation|self
    {
        $query = (new Query('linkFileToEntity', []))->addVariable(['input' => ['fileable_type' => $fileable_type, 'fileable_id' => $fileable_id, 'files' => [$this->id]]], 'LinkFileToEntityMutationInput');

        return $this->batchMutation($query, $batch_request);
    }
}
