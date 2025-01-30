<?php

namespace Kengineering\Sonar\Objects;

use Kengineering\Sonar\Graphql\Query;
use Kengineering\Sonar\Operations\Mutation;
use Exception;
/**
 * @property int $id
 * @property string $sonar_unique_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $_version
 * @property int $account_id
 * @property string $addition_prorate_date
 * @property string $data_usage_last_calculated_date
 * @property string $name_override
 * @property string $next_bill_date
 * @property int $number_of_times_billed
 * @property int $package_id
 * @property int $price_override
 * @property string $price_override_reason
 * @property int $quantity
 * @property int $service_id
 * @property string $unique_package_relationship_id
 * @property Account $account
 * @property Service $service
 * @property ?Package $package
 */
class AccountService extends SonarObject
{
    const PROPERTIES = [
        'id',
        'sonar_unique_id',
        'created_at',
        'updated_at',
        '_version',
        'account_id',
        'addition_prorate_date',
        'data_usage_last_calculated_date',
        'name_override',
        'next_bill_date',
        'number_of_times_billed',
        'package_id',
        'price_override',
        'price_override_reason',
        'quantity',
        'service_id',
        'unique_package_relationship_id',
    ];

    const RELATED_OBJECTS = [
        'service' => 'one',
        'package' => 'one',
        'account' => 'one',
    ];

    public function removePackage(bool $prorate = false, string $proration_date = '', bool $batch_request = false): Mutation|self
    {
        if (!$this->exists()) {
            throw new Exception('this accountService does not exist in sonar can cant be removed');
        } else if (is_null($this->package_id)) {
            throw new Exception('this Account Service does not belong to a package');
        }

        $query = new Query('deleteAccountPackage', ['success', 'message']);

        if ($prorate) {
            $input['prorate'] = $prorate;
            $input['proration_date'] = $proration_date;
        } else {
            $input = [];
        }

        $query->addVariable(
            ['input' => $input,],
            'DeleteAccountServiceMutationInput'
        );

        $query->addVariable(
            ['unique_package_relationship_id' => $this->unique_package_relationship_id],
            'String',
            true
        );

        return $this->batchMutation($query, $batch_request);
    }
}
