<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class ClearanceAreaItemService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function searchClearanceAreaItemByClearanceId(int $param_clearance_id)
    {
			try {
        $search = $param_clearance_id ?? 0;       
        $result = $this->sp
                  ->stored_procedure('pr_clearance_area_item_by_clearance_id_sel')
                  ->stored_procedure_connection('iclearance_connection')
                  ->stored_procedure_params([':clearance_id'])
                  ->stored_procedure_values([$search])
                  ->execute();

        return $result->stored_procedure_result();
			} catch (Exception $exception) {
					throw new Exception('Error getting clearance area options', 500, $exception);
			}
    }
    
}
