<?php

namespace Kengineering\Sonar\Objects;

/**
 * @property int $default_vendor_id
 * @property string $device_type
 * @property bool $enabled
 * @property bool $generic
 * @property string $icon
 * @property int $inventory_model_category_id
 * @property string $lte_sim_type
 * @property int $manufacturer_id
 * @property string $model_name
 * @property string $name
 * @property int $network_monitoring_template_id
 * @property int $port
 * @property string $protocol
 * @property array<InventoryItem> $inventory_items
 */
class InventoryModel extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'default_vendor_id',
        'device_type',
        'enabled',
        'generic',
        'icon',
        'inventory_model_category_id',
        'lte_sim_type',
        'manufacturer_id',
        'model_name',
        'name',
        'network_monitoring_template_id',
        'port',
        'protocol',
    ];

    const RELATED_OBJECTS = [
        'inventory_item' => 'many',
    ];
}
