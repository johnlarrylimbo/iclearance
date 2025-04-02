<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class EmployeeClearanceService extends Service
{
	protected SP $sp;

	public function __construct(SP $sp)
	{
			$this->sp = $sp;
	}
	//instantiate brand model class

	public function loadEmployeeClearanceLst(int $clearance_id_value){
		try {
      $clearance_id = $clearance_id_value ?? 0;    
				$result = $this->sp
						->stored_procedure('pr_employee_clearance_by_clearance_id_lst')
						->stored_procedure_connection('iclearance_connection')
            ->stored_procedure_params([':clearance_id'])
						->stored_procedure_values([$clearance_id])
						->execute();

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting employee clearance list', 500, $exception);
		}
	}

	public function searchEmployeeClearanceLstByClearanceIdKeyword(int $clearance_id_value, string $search_query)
	{
		try {
      $clearance_id = $clearance_id_value ?? 0;
			$search = $search_query ?? '';       
				$result = $this->sp
									->stored_procedure('pr_employee_clearance_by_keword_clearance_id_lst')
									->stored_procedure_connection('iclearance_connection')
									->stored_procedure_params([':clearance_id, :keyword'])
									->stored_procedure_values([$clearance_id, $search])
									->execute();

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting clearance area options', 500, $exception);
		}
	}

  public function loadEmployeeClearanceAreaByClearanceIdLst(int $clearance_id_value){
		try {
      $clearance_id = $clearance_id_value ?? 0;    
				$result = $this->sp
						->stored_procedure('pr_employee_clearance_area_by_clearance_id_lst')
						->stored_procedure_connection('iclearance_connection')
            ->stored_procedure_params([':clearance_id'])
						->stored_procedure_values([$clearance_id])
						->execute();

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting employee clearance list', 500, $exception);
		}
	}

  public function loadedEmployeeClearanceAreaByClearanceId(int $clearance_id_value){
		try {
      $clearance_id = $clearance_id_value ?? 0;    
				$result = $this->sp
						->stored_procedure('pr_employee_clearance_area_by_clearance_id_sel')
						->stored_procedure_connection('iclearance_connection')
            ->stored_procedure_params([':clearance_id'])
						->stored_procedure_values([$clearance_id])
						->execute();

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting employee clearance list', 500, $exception);
		}
	}

  public function UpdateEmployeeClearanceAreaStatus(int $clearance_detail_id_value, int $clearance_area_id_value, int $status_value){
		try {
      $clearance_detail_id = $clearance_detail_id_value ?? 0;
      $clearance_area_id = $clearance_area_id_value ?? 0;
      $status = $status_value ?? 0;    
				$result = $this->sp
						->stored_procedure('pr_employee_clearance_area_status_upd')
						->stored_procedure_connection('iclearance_connection')
            ->stored_procedure_params([':clearance_detail_id, :clearance_area_id, :status, :result_id'])
						->stored_procedure_values([$clearance_detail_id, $clearance_area_id, $status, 0])
						->execute();

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting employee clearance list', 500, $exception);
		}
	}
    
}
