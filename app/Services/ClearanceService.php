<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class ClearanceService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function loadClearance()
    {
			try {
				$result = $this->sp
						->stored_procedure('pr_clearance_lst')
						->stored_procedure_connection('iclearance_connection')
						->execute();

				return $result->stored_procedure_result();
			} catch (Exception $exception) {
				throw new Exception('Error getting clearance', 500, $exception);
			}
    }

    public function searchClearanceByKeyword(string $search_query)
    {
			try {
        $search = $search_query ?? '';
				$result = $this->sp
									->stored_procedure('pr_clearance_by_search_lst')
									->stored_procedure_connection('iclearance_connection')
									->stored_procedure_params([':keyword'])
									->stored_procedure_values([$search])
									->execute();

				return $result->stored_procedure_result();
			} catch (Exception $exception) {
				throw new Exception('Error getting roles options', 500, $exception);
			}
    }

    public function loadClearanceFacultyHigherEducation()
    {
			try {
				$result = $this->sp
						->stored_procedure('pr_clearance_faculty_higher_education_lst')
						->stored_procedure_connection('iclearance_connection')
						->execute();

				return $result->stored_procedure_result();
			} catch (Exception $exception) {
				throw new Exception('Error getting clearance faculty higher education', 500, $exception);
			}
    }

    public function searchClearanceFacultyHigherEducationByKeyword(string $search_query)
    {
			try {
        $search = $search_query ?? '';
				$result = $this->sp
									->stored_procedure('pr_clearance_faculty_higher_education_by_keyword_lst')
									->stored_procedure_connection('iclearance_connection')
									->stored_procedure_params([':keyword'])
									->stored_procedure_values([$search])
									->execute();

				return $result->stored_procedure_result();
			} catch (Exception $exception) {
				throw new Exception('Error gettingclearance faculty higher education by keyword', 500, $exception);
			}
    }

    public function getClearanceEmployeeRecordByClearanceId(int $param_clearance_id)
    {
			try {
        $search = $param_clearance_id ?? 0;
        $result = $this->sp
                  ->stored_procedure('pr_clearance_employee_record_by_clearance_id')
                  ->stored_procedure_connection('iclearance_connection')
                  ->stored_procedure_params([':clearance_id'])
                  ->stored_procedure_values([$search])
                  ->execute();

        return $result->stored_procedure_result();
			} catch (Exception $exception) {
					throw new Exception('Error getting clearance employee', 500, $exception);
			}
    }

    public function getClearanceEmployeeRecordByKeywordClearanceId(int $param_clearance_id, string $search_query)
    {
			try {
				$clearance_id = $param_clearance_id ?? 0;
				$keyword = $search_query ?? '';
				$result = $this->sp
									->stored_procedure('pr_clearance_employee_record_by_keyword_clearance_id')
									->stored_procedure_connection('iclearance_connection')
									->stored_procedure_params([':clearance_id, :keyword'])
									->stored_procedure_values([$clearance_id, $keyword])
									->execute();

				return $result->stored_procedure_result();
			} catch (Exception $exception) {
					throw new Exception('Error getting roles options', 500, $exception);
			}
    }

    public function loadClearanceSupportServicerPersonnel()
    {
			try {
				$result = $this->sp
						->stored_procedure('pr_clearance_support_service_personnel_lst')
						->stored_procedure_connection('iclearance_connection')
						->execute();

				return $result->stored_procedure_result();
			} catch (Exception $exception) {
				throw new Exception('Error getting clearance faculty higher education', 500, $exception);
			}
    }

    public function searchClearanceSupportServicerPersonnelByKeyword(string $search_query)
    {
			try {
        $search = $search_query ?? '';
				$result = $this->sp
									->stored_procedure('pr_clearance_support_service_personnel_by_keyword_lst')
									->stored_procedure_connection('iclearance_connection')
									->stored_procedure_params([':keyword'])
									->stored_procedure_values([$search])
									->execute();

				return $result->stored_procedure_result();
			} catch (Exception $exception) {
				throw new Exception('Error gettingclearance faculty higher education by keyword', 500, $exception);
			}
    }

}
