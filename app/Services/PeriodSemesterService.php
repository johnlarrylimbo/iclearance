<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class PeriodSemesterService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function loadPeriodSemesterOptions()
    {
        try {
            $result = $this->sp
                ->stored_procedure('pr_period_semester_select_options')
                ->stored_procedure_connection('iclearance_connection')
                ->execute();

            return $result->stored_procedure_result();
        } catch (Exception $exception) {
            throw new Exception('Error getting period type', 500, $exception);
        }
    }
    
}
