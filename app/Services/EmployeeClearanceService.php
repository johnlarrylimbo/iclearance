<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;
use Illuminate\Support\Facades\Log;

class EmployeeClearanceService extends Service
{
	protected SP $sp;

	public function __construct(SP $sp)
	{
			$this->sp = $sp;
	}
	//instantiate brand model class

  public function EmployeeClearanceByClearanceId(int $clearance_id_value){
		try {
      $clearance_id = $clearance_id_value ?? 0;    
				$result = $this->sp
						->stored_procedure('pr_employee_clearance_by_clearance_id_sel')
						->stored_procedure_connection('iclearance_connection')
            ->stored_procedure_params([':clearance_id'])
						->stored_procedure_values([$clearance_id])
						->execute();

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting employee clearance list', 500, $exception);
		}
	}

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

	public function searchloadEmployeeClearanceAreaByClearanceIdLst(int $clearance_id_value, string $search_query)
	{
		try {
      $clearance_id = $clearance_id_value ?? 0;
			$search = $search_query ?? '';       
				$result = $this->sp
									->stored_procedure('pr_employee_clearance_area_by_clearance_id_keyword_lst')
									->stored_procedure_connection('iclearance_connection')
									->stored_procedure_params([':clearance_id, :keyword'])
									->stored_procedure_values([$clearance_id, $search])
									->execute();

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting clearance area options', 500, $exception);
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

  // public function UpdateEmployeeClearanceAreaStatus(int $clearance_detail_area_id_value, int int $status_value, int $user_account_id_value){
	// 	try {
  //     $clearance_detail_id = $clearance_detail_id_value ?? 0;
  //     $clearance_area_id = $clearance_area_id_value ?? 0;
  //     $status = $status_value ?? 0;    
	// 		$user_account_id = $user_account_id_value ?? 0;    
	// 			$result = $this->sp
	// 					->stored_procedure('pr_employee_clearance_area_status_upd')
	// 					->stored_procedure_connection('iclearance_connection')
  //           ->stored_procedure_params([':clearance_detail_id, :clearance_area_id, :status, :user_account_id, :result_id'])
	// 					->stored_procedure_values([$clearance_detail_id, $clearance_area_id, $status, $user_account_id, 0])
	// 					->execute();

	// 			return $result->stored_procedure_result();
	// 	} catch (Exception $exception) {
	// 			throw new Exception('Error getting employee clearance list', 500, $exception);
	// 	}
	// }

	public function GetActiveEmployeeClearanceByEmployeeId(int $employee_id_value){
		try {
      $employee_id = $employee_id_value ?? 0;
				$result = $this->sp
						->stored_procedure('pr_employee_clearance_by_employee_id_active_clearance_sel')
						->stored_procedure_connection('iclearance_connection')
            ->stored_procedure_params([' :employee_id '])
						->stored_procedure_values([ $employee_id ])
						->execute();

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting employee clearance list', 500, $exception);
		}
	}

	public function GetActiveEmployeeClearanceDetailByEmployeeId(int $employee_id_value){
		try {
      $employee_id = $employee_id_value ?? 0;
				$result = $this->sp
						->stored_procedure('pr_employee_clearance_detail_by_employee_id')
						->stored_procedure_connection('iclearance_connection')
            ->stored_procedure_params([' :employee_id '])
						->stored_procedure_values([ $employee_id ])
						->execute();

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting employee clearance list', 500, $exception);
		}
	}

	public function GetActiveEmployeeClearanceDetailByAuthorizedEmployeeId(int $employee_id_value, int $user_account_id_value){
		try {
      $employee_id = $employee_id_value ?? 0;
			$user_account_id = $user_account_id_value ?? 0;    
				$result = $this->sp
						->stored_procedure('pr_employee_clearance_detail_by_authorized_employee_id')
						->stored_procedure_connection('iclearance_connection')
            ->stored_procedure_params([' :employee_id, :user_account_id '])
						->stored_procedure_values([ $employee_id, $user_account_id ])
						->execute();

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting employee clearance list', 500, $exception);
		}
	}

	public function UpdateEmployeeClearanceAreaDetailStatus(int $clearance_detail_area_id_value, int $status_value, int $user_account_id_value){
		try {
      $clearance_detail_area_id = $clearance_detail_area_id_value ?? 0;
      $status = $status_value ?? 0;    
			$user_account_id = $user_account_id_value ?? 0;    
				$result = $this->sp
						->stored_procedure('pr_employee_clearance_area_detail_status_upd')
						->stored_procedure_connection('iclearance_connection')
            ->stored_procedure_params([':clearance_detail_area_id, :status, :user_account_id, :result_id'])
						->stored_procedure_values([$clearance_detail_area_id, $status, $user_account_id, 0])
						->execute();

						Log::channel('transaction')->info('Updated clearance area status:', ['clearance_detail_area_id' => auth()->user()->user_account_id]);
						// Log::channel('transaction')->debug('User action', ['user_id' => auth()->user()->user_account_id]);

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting employee clearance list', 500, $exception);
		}
	}

	public function loadEmployeeClearanceAreaByClearanceDetailIdLst(int $clearance_id_value){
		try {
      $clearance_id = $clearance_id_value ?? 0;    
				$result = $this->sp
						->stored_procedure('pr_employee_clearance_area_by_clearance_detail_id_lst')
						->stored_procedure_connection('iclearance_connection')
            ->stored_procedure_params([':clearance_detail_id'])
						->stored_procedure_values([$clearance_id])
						->execute();

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting employee clearance list', 500, $exception);
		}
	}
    
}
