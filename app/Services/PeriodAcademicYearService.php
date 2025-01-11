<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class PeriodAcademicYearService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function loadPeriodAcademicYearOptions()
    {
        try {
            $result = $this->sp
                ->stored_procedure('pr_period_academic_year_select_options')
                ->stored_procedure_connection('iclearance_connection')
                ->execute();

            return $result->stored_procedure_result();
        } catch (Exception $exception) {
            throw new Exception('Error getting period type', 500, $exception);
        }
    }
    
}
