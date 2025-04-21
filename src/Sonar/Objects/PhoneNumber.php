<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $contact_id
 * @property string $country
 * @property string $extension
 * @property string $number
 * @property string $number_formatted
 * @property int $phone_number_type_id
 * @property bool $sms_opt_in
 * @property Contact $contact
 */
class PhoneNumber extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'contact_id',
        'country',
        'extension',
        'number',
        'number_formatted',
        'phone_number_type_id',
        'sms_opt_in',
    ];

    const RELATED_OBJECTS = [
        'phone_number_type' => 'one',
        'contact' => 'one',
    ];
}
