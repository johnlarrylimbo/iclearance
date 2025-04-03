<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class ClearanceEmployeeEnrollmentService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function checkEmployeeClearanceDetailByEmployeeClearanceId(int $clearance_id_value, int $employee_id_value)
    {
			try {
        $clearance_id = $clearance_id_value ?? 0;   
				$employee_id = $employee_id_value ?? 0;       
					$result = $this->sp
										->stored_procedure('pr_employee_clearance_detail_check_exist_by_employee_clearance_id')
										->stored_procedure_connection('iclearance_connection')
										->stored_procedure_params([':clearance_id, :employee_id, :result_id'])
										->stored_procedure_values([$clearance_id, $employee_id, 0])
										->execute();

					return $result->stored_procedure_result();
			} catch (Exception $exception) {
					throw new Exception('Error checking employee detail by employee clearance id', 500, $exception);
			}
    }

    public function populateEmployeeClearanceDetailByEmployeeClearanceId(int $clearance_id_value, int $employee_id_value, int $account_id_value)
    {
			try {
        $clearance_id = $clearance_id_value ?? 0;   
				$employee_id = $employee_id_value ?? 0; 
				$account_id = $account_id_value ?? 0;       
					$result = $this->sp
										->stored_procedure('pr_employee_clearance_detail_populate_by_employee_clearance_id')
										->stored_procedure_connection('iclearance_connection')
										->stored_procedure_params([':clearance_id, :employee_id, :account_id, :result_id'])
										->stored_procedure_values([$clearance_id, $employee_id, $account_id, 0])
										->execute();

					return $result->stored_procedure_result();
			} catch (Exception $exception) {
					throw new Exception('Error adding employee clearance detail', 500, $exception);
			}
    }
    
}
