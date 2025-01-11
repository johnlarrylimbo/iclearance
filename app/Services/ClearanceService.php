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
    
}
