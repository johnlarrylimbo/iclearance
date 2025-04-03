<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class EmployeeService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function loadEmployeeLst(int $clearance_id_value)
    {
			try {
				$clearance_id = $clearance_id_value ?? 0;
					$result = $this->sp
							->stored_procedure('pr_employee_lst_from_lw32016_db')
							->stored_procedure_connection('iclearance_connection')
							->stored_procedure_params([':clearance_id'])
									->stored_procedure_values([$clearance_id])
							->execute();

					return $result->stored_procedure_result();
			} catch (Exception $exception) {
					throw new Exception('Error getting employee list', 500, $exception);
			}
    }

    public function searchEmployeeLstByKeyword(int $clearance_id_value, string $search_query)
    {
			try {
				$clearance_id = $clearance_id_value ?? 0;
        $search = $search_query ?? '';       
					$result = $this->sp
										->stored_procedure('pr_employee_lst_from_lw32016_db_by_keyword_sel')
										->stored_procedure_connection('iclearance_connection')
										->stored_procedure_params([':clearance_id, :keyword'])
										->stored_procedure_values([$clearance_id, $search])
										->execute();

					return $result->stored_procedure_result();
			} catch (Exception $exception) {
					throw new Exception('Error getting employee list by keyword', 500, $exception);
			}
    }

		public function loadEmployeeDetailByEmployeeId(int $employee_id_value)
    {
			try {
        $employee_id = $employee_id_value ?? 0;       
					$result = $this->sp
										->stored_procedure('pr_employee_lst_from_lw32016_db_by_employee_id')
										->stored_procedure_connection('iclearance_connection')
										->stored_procedure_params([':employee_id'])
										->stored_procedure_values([$employee_id])
										->execute();

					return $result->stored_procedure_result();
			} catch (Exception $exception) {
					throw new Exception('Error getting employee detail by employee id', 500, $exception);
			}
    }
    
}
