<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class AccessPermissionService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function loadAccessPermissionRequest($account_id)
    {
        try {
            $result = $this->sp
                ->stored_procedure('pr_access_permission_request_by_account_id_sel')
                ->stored_procedure_params(['?'])
                ->stored_procedure_values([$account_id])
                ->stored_procedure_connection('iclearance_connection')
                ->execute();

            return $result->stored_procedure_result();
        } catch (Exception $exception) {
            throw new Exception('Error getting access permission request', 500, $exception);
        }
    }
    
}
