<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class ClearanceAreaService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function loadClearanceArea()
    {
        try {
            $result = $this->sp
                ->stored_procedure('pr_clearance_area_lst')
                ->stored_procedure_connection('iclearance_connection')
                ->execute();

            return $result->stored_procedure_result();
        } catch (Exception $exception) {
            throw new Exception('Error getting clearance area', 500, $exception);
        }
    }

    public function loadClearanceAreaOptions()
    {
			try {
					$result = $this->sp
							->stored_procedure('pr_clearance_area_select_options')
							->execute();

					return $result->stored_procedure_result();
			} catch (Exception $exception) {
					throw new Exception('Error getting clearance area options', 500, $exception);
			}
    }
    
}
