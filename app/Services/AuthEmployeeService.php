<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class AuthEmployeeService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function getAuthEmployeeClearanceAreaPermissionByAccountId(int $param_account_id)
    {
			try {
        $search = $param_account_id ?? 0;       
        $result = $this->sp
                  ->stored_procedure('pr_auth_employee_clearance_area_by_account_id_sel')
                  ->stored_procedure_connection('iclearance_connection')
                  ->stored_procedure_params([':account_id'])
                  ->stored_procedure_values([ $search ])
                  ->execute();

        return $result->stored_procedure_result();
			} catch (Exception $exception) {
					throw new Exception('Error getting clearance area options', 500, $exception);
			}
    }
    
}
