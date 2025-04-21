<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property string $address_on_completion
 * @property bool $complete
 * @property int $completed_by_user_id
 * @property bool $completed_successfully
 * @property string $completion_datetime
 * @property string $completion_notes
 * @property int $job_type_id
 * @property int $jobbable_id
 * @property string $jobbable_type
 * @property int $length_in_minutes
 * @property string $scheduled_datetime
 * @property int $serviceable_address_account_assignment_future_id
 * @property bool $skips_validation
 * @property int $ticket_id
 * @property JobType $job_type
 * @property Account $account
 */
class Job extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'address_on_completion',
        'complete',
        'completed_by_user_id',
        'completed_successfully',
        'completion_datetime',
        'completion_notes',
        'job_type_id',
        'jobbable_id',
        'jobbable_type',
        'length_in_minutes',
        'scheduled_datetime',
        'serviceable_address_account_assignment_future_id',
        'skips_validation',
        'ticket_id',
    ];

    const RELATED_OBJECTS = [
        'account' => 'owned_by',
        'job_type' => 'one',
    ];

    const OWNED_ACCESS_NAME = 'jobbable';
}
