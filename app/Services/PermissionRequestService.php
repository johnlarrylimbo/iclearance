<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class PermissionRequestService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function loadPermissionRequest()
    {
        try {
            $result = $this->sp
                ->stored_procedure('pr_permission_request_lst')
                ->stored_procedure_connection('iclearance_connection')
                ->execute();

            return $result->stored_procedure_result();
        } catch (Exception $exception) {
            throw new Exception('Error getting access permission request', 500, $exception);
        }
    }
    
}
