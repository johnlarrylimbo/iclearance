<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class ClearanceDetailService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function getEmployeeClearanceAreaItemByDetailId(int $param_clearance_detail_id, int $param_account_id)
    {
			try {
        $search = $param_clearance_detail_id ?? 0;
        $account_id = $param_account_id ?? 0;       
        $result = $this->sp
                  ->stored_procedure('pr_clearance_detail_area_employee_by_clearance_id_sel')
                  ->stored_procedure_connection('iclearance_connection')
                  ->stored_procedure_params([':clearance_detail_id, :account_id'])
                  ->stored_procedure_values([ $search, $account_id ])
                  ->execute();

        return $result->stored_procedure_result();
			} catch (Exception $exception) {
					throw new Exception('Error getting clearance area options', 500, $exception);
			}
    }
    
}
