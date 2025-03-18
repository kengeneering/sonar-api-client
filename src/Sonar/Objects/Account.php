<?php

namespace Kengineering\Sonar\Objects;

use Kengineering\Sonar\Graphql\Query;
use Kengineering\Sonar\Operations\Mutation;
use Exception;

/**
 * @property int $account_status_id
 * @property int $account_type_id
 * @property string $activation_date
 * @property string $activation_time
 * @property int $company_id
 * @property int $data_usage_percentage
 * @property bool $is_delinquent
 * @property string $name
 * @property string $next_bill_date
 * @property int $next_recurring_charge_amount
 * @property int $parent_account_id
 * @property string|null $archived_at
 * @property bool|null $is_eligible_for_archive
 * @property int|null $archived_by_user_id
 * @property AccountType|null $account_type
 * @property AccountStatus|null $account_status
 * @property array<AccountService>|null $account_services
 * @property array<Address>|null $addresses
 * @property array<CustomFieldData>|null $custom_field_data
 * @property array<Log>|null $logs
 */
class Account extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'account_status_id',
        'account_type_id',
        'activation_date',
        'activation_time',
        'is_eligible_for_archive',
        'archived_at',
        'archived_by_user_id',
        'company_id',
        'data_usage_percentage',
        'is_delinquent',
        'name',
        'next_bill_date',
        'next_recurring_charge_amount',
        'parent_account_id',
    ];

    const RELATED_OBJECTS = [
        'account_type' => 'one',
        'account_status' => 'one',
        'account_service' => 'many',
        'address' => 'many',
        'custom_field_data' => 'many',
        'log' => 'many',
    ];

    const CREATE_PROPERTIES = [
        'name',
        'account_status_id',
        'account_type_id',
        'serviceable_address_id',
        'mailing_address',
        'primary_contact',
        'account_group_ids',
        'company_id',
        'custom_field_data',
        'unset_custom_field_data',
        'files',
    ];

    const UPDATE_PROPERTIES = [
        'name',
        'account_status_id',
        'account_type_id',
        'serviceable_address_id',
        'account_group_ids',
        'company_id',
        'prorate',
        'custom_field_data',
        'unset_custom_field_data',
        'note',
        'files',
        'tasks',
    ];

    public function addService(int|Service $service, bool $batch_request = false, int $quantity = 1): Mutation|self
    {
        $service = $this->check_existance_return_object_value($service);

        $query = (new Query('addServiceToAccount', ['id']))->addVariable(['input' => ['service_id' => $service, 'account_id' => $this->id, 'quantity' => $quantity]], 'AddServiceToAccountMutationInput');

        return $this->batchMutation($query, $batch_request);
    }

    public function addPackage(int|Package $package, bool $batch_request = false, int $quantity = 1): Mutation|self
    {

        $package = $this->check_existance_return_object_value($package);

        $query = (new Query('addPackageToAccount', ['id']))->addVariable(['input' => ['package_id' => $package, 'account_id' => $this->id, 'quantity' => $quantity]], 'AddPackageToAccountMutationInput');

        return $this->batchMutation($query, $batch_request);
    }

    public function archive(bool $batch_request = false): Mutation|self
    {
        $this->existOrFail();
        $query = (new Query('archiveAccount', ['id']))->addVariable([$this->id], 'id');

        return $this->batchMutation($query, $batch_request);
    }

    public function serviceable_address(): ?Address
    {
        $this->existOrFail();
        if (!is_null($this->addresses)) {
            foreach ($this->addresses as $address) {
                if ($address->serviceable === true) {
                    return $address;
                }
            }

            return null;
        }
        $updated_account = $this->refresh_object([Address::class]);
        $this->addresses = $updated_account->addresses;

        return $updated_account->serviceable_address();
    }
}
