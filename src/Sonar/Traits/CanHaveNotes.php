<?php

namespace Kengineering\Sonar\Traits;
use Kengineering\Sonar\Objects\Note;
use Kengineering\Sonar\Graphql\Query;
use Kengineering\Sonar\Enums\NotePriority;

trait CanHaveNotes
{
    /**
     * @param NotePriority $priority
     * @property array<Note>|null $notes
     */


    public function addNote(string $message, NotePriority $priority = NotePriority::NORMAL, bool $batch_request = false)
    {

        $query = (new Query('createNote', ['id']))->addVariable(['input' => ['message' => $message, 'noteable_id' => $this->id, 'noteable_type' => basename(str_replace('\\', '/', static::class)), 'priority' => $priority]], 'CreateNoteMutationInput');

        return $this->batchMutation($query, $batch_request);
    }

}