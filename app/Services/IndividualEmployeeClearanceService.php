<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class IndividualEmployeeClearanceService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function searchIndividualEmployeeClearanceByKeyword(string $search_query)
    {
			try {
        $search = $search_query ?? '';
				$result = $this->sp
									->stored_procedure('pr_employee_by_keyword_sel')
									->stored_procedure_connection('iclearance_connection')
									->stored_procedure_params([':keyword'])
									->stored_procedure_values([$search])
									->execute();

				return $result->stored_procedure_result();
			} catch (Exception $exception) {
				throw new Exception('Error getting roles options', 500, $exception);
			}
    }
}
