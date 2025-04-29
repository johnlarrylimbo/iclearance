<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class MyClearanceService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function loadMyClearanceLst(int $param_user_account_id)
    {
			try {
        $user_account_id = $param_user_account_id ?? 0;
        $result = $this->sp
                  ->stored_procedure('pr_clearance_my_clearance_by_user_account_id_lst')
                  ->stored_procedure_connection('iclearance_connection')
                  ->stored_procedure_params([':user_account_id'])
                  ->stored_procedure_values([$user_account_id])
                  ->execute();

        return $result->stored_procedure_result();
			} catch (Exception $exception) {
					throw new Exception('Error getting clearance employee', 500, $exception);
			}
    }

    public function searchMyClearanceLstByKeyword( string $search_query, int $param_user_account_id)
	{
		try {
			$search = $search_query ?? ''; 
      $user_account_id = $param_user_account_id ?? 0;      
				$result = $this->sp
									->stored_procedure('pr_clearance_my_clearance_by_user_account_id_keyword_lst')
									->stored_procedure_connection('iclearance_connection')
									->stored_procedure_params([':keyword, :user_account_id'])
									->stored_procedure_values([$search, $user_account_id])
									->execute();

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting clearance area options', 500, $exception);
		}
	}

    public function loadMyClearanceDetailByClearanceDetailId(int $param_clearance_detail_id)
    {
			try {
        $clearance_detail_id = $param_clearance_detail_id ?? 0;
        $result = $this->sp
                  ->stored_procedure('pr_my_clearance_detail_by_clearance_detail_id')
                  ->stored_procedure_connection('iclearance_connection')
                  ->stored_procedure_params([':clearance_detail_id'])
                  ->stored_procedure_values([$clearance_detail_id])
                  ->execute();

        return $result->stored_procedure_result();
			} catch (Exception $exception) {
					throw new Exception('Error getting clearance employee', 500, $exception);
			}
    }
}
