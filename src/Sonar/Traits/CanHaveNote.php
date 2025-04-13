<?php

namespace Kengineering\Sonar\Traits;
use Kengineering\Sonar\Objects\Note;
use Kengineering\Sonar\Graphql\Query;

trait CanHaveNote

{

    /**
     * 
     * @property array<Note>|null $account_services
     */

    public function addNote(string $message, string $priority = 'NORMAL', bool $batch_request = false)
    {

        $query = (new Query('createNote', ['id']))->addVariable(['input' => ['message' => $message, 'notable_id' => $this->id, 'noteable_type' => basename(str_replace('\\', '/', static::class)), 'priority' => $priority]], 'CreateNoteMutationInput');

        return $this->batchMutation($query, $batch_request);
    }

}