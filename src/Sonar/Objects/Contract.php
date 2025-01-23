<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $account_id
 * @property string $body
 * @property int $contact_id
 * @property int $contract_template_id
 * @property string $custom_message
 * @property string $expiration_date
 * @property int $handwritten_signature_id
 * @property string $name
 * @property int $term_in_months
 * @property string $unique_link_key
 * @property ?Account $account
 * @property ?Contact $contact
 */
class Contract extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'account_id',
        'body',
        'contact_id',
        'contract_template_id',
        'custom_message',
        'expiration_date',
        'handwritten_signature_id',
        'name',
        'term_in_months',
        'unique_link_key',
    ];

    const RELATED_OBJECTS = [
        'account' => 'one',
        'contact' => 'one',
    ];
}
