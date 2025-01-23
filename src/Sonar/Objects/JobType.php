<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $account_status_id_completion
 * @property int $account_status_id_failure
 * @property string $action_on_completion
 * @property string $action_on_failure
 * @property bool $all_companies
 * @property bool $allow_completion_with_incomplete_tasks
 * @property string $color
 * @property int $contract_template_id
 * @property int $default_length_in_minutes
 * @property bool $disconnects_account
 * @property bool $enabled
 * @property string $icon
 * @property string $name
 * @property int $task_template_id
 * @property int $ticket_group_id_completion
 * @property int $ticket_group_id_failure
 * @property string $ticket_status_on_completion
 * @property string $ticket_status_on_failure
 * @property ?array<Job> $jobs
 * @property ?array<Service> $services
 */
class JobType extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'account_status_id_completion',
        'account_status_id_failure',
        'action_on_completion',
        'action_on_failure',
        'all_companies',
        'allow_completion_with_incomplete_tasks',
        'color',
        'contract_template_id',
        'default_length_in_minutes',
        'disconnects_account',
        'enabled',
        'icon',
        'name',
        'task_template_id',
        'ticket_group_id_completion',
        'ticket_group_id_failure',
        'ticket_status_on_completion',
        'ticket_status_on_failure',
    ];

    const RELATED_OBJECTS = [
        'job' => 'many',
    ];
}
