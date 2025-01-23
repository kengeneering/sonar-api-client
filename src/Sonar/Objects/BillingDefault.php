<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $account_type_id
 * @property bool $aggregate_invoice_taxes
 * @property bool $aggregate_linked_debits
 * @property int $anchor_default_id
 * @property string $anchor_delinquency_logic
 * @property string $auto_pay_day
 * @property int $auto_pay_days
 * @property int $bill_day
 * @property string $bill_day_mode
 * @property string $bill_mode
 * @property int $days_of_delinquency_for_status_switch
 * @property bool $default
 * @property string $default_for
 * @property int $delinquency_account_status_id
 * @property int $delinquency_removal_account_status_id
 * @property int $due_days
 * @property string $due_days_day
 * @property bool $fixed_bill_day
 * @property int $grace_days
 * @property int $invoice_day
 * @property bool $lifeline
 * @property int $months_to_bill
 * @property string $name
 * @property bool $print_invoice
 * @property bool $switch_status_after_delinquency
 * @property bool $tax_exempt
 * @property array<BillingService> $billing_services
 * @property array<Address> $addresses
 */
class BillingDefault extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version', 'account_type_id',
        'aggregate_invoice_taxes',
        'aggregate_linked_debits',
        'anchor_default_id',
        'anchor_delinquency_logic',
        'auto_pay_day',
        'auto_pay_days',
        'bill_day',
        'bill_day_mode',
        'bill_mode',
        'days_of_delinquency_for_status_switch',
        'default',
        'default_for',
        'delinquency_account_status_id',
        'delinquency_removal_account_status_id',
        'due_days',
        'due_days_day',
        'fixed_bill_day',
        'grace_days',
        'invoice_day',
        'lifeline',
        'months_to_bill',
        'name',
        'print_invoice',
        'switch_status_after_delinquency',
        'tax_exempt',
    ];

    const RELATED_OBJECTS = [
        'address' => 'many',
        'billing_service' => 'many',
    ];
}
