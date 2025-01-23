<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $claimed_user_id
 * @property int $deployment_type_id
 * @property bool $flapping
 * @property string $icmp_device_status
 * @property int $icmp_status_flap_count
 * @property string $icmp_status_last_change
 * @property string $icmp_threshold_violation
 * @property int $inventory_model_id
 * @property int $inventoryitemable_id
 * @property string $inventoryitemable_type
 * @property float $latitude
 * @property float $longitude
 * @property string $metadata
 * @property string $overall_status
 * @property string $override_status
 * @property string $override_status_last_change
 * @property int $parent_inventory_item_id
 * @property string $preseem_status
 * @property int $purchase_order_item_id
 * @property int $purchase_price
 * @property string $snmp_device_status
 * @property int $snmp_status_flap_count
 * @property string $snmp_status_last_change
 * @property string $snmp_status_message
 * @property string $status
 * @property InventoryModel $inventory_model
 * @property Address $address
 */
class InventoryItem extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version', 'claimed_user_id',
        'deployment_type_id',
        'flapping',
        'icmp_device_status',
        'icmp_status_flap_count',
        'icmp_status_last_change',
        'icmp_threshold_violation',
        'inventory_model_id',
        'inventoryitemable_id',
        'inventoryitemable_type',
        'latitude',
        'longitude',
        'metadata',
        'overall_status',
        'override_status',
        'override_status_last_change',
        'parent_inventory_item_id',
        'preseem_status',
        'purchase_order_item_id',
        'purchase_price',
        'snmp_device_status',
        'snmp_status_flap_count',
        'snmp_status_last_change',
        'snmp_status_message',
        'status',
    ];

    const RELATED_OBJECTS = [
        'inventory_model' => 'one',
        'address' => 'owned_by',
    ];

    const OWNED_ACCESS_NAME = 'inventoryitemable';
}
