<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class ClearanceManagementService extends Service
{
	protected SP $sp;

	public function __construct(SP $sp)
	{
			$this->sp = $sp;
	}
	//instantiate brand model class

	public function loadClearanceLst(){
		try {
				$result = $this->sp
						->stored_procedure('pr_clearance_lst')
						->stored_procedure_connection('iclearance_connection')
						->execute();

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting clearance list', 500, $exception);
		}
	}

	public function searchClearanceLstByKeyword(string $search_query)
	{
		try {
			$search = $search_query ?? '';       
				$result = $this->sp
									->stored_procedure('pr_clearance_lst_by_keyword')
									->stored_procedure_connection('iclearance_connection')
									->stored_procedure_params([':keyword'])
									->stored_procedure_values([$search])
									->execute();

				return $result->stored_procedure_result();
		} catch (Exception $exception) {
				throw new Exception('Error getting clearance area options', 500, $exception);
		}
	}
    
}
