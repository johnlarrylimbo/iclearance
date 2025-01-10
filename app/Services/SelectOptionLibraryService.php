<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class SelectOptionLibraryService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function loadSortingNumbers()
    {
        try {
            $result = $this->sp
                ->stored_procedure('pr_clearance_area_sort_select_options')
                ->stored_procedure_connection('iclearance_connection')
                ->execute();

            return $result->stored_procedure_result();
        } catch (Exception $exception) {
            throw new Exception('Error getting sorting numbers', 500, $exception);
        }
    }

    public function loadYesNoSelectOptions()
    {
        try {
            $result = $this->sp
                ->stored_procedure('pr_select_option_library_yes_no_lst')
                ->stored_procedure_connection('iclearance_connection')
                ->execute();

            return $result->stored_procedure_result();
        } catch (Exception $exception) {
            throw new Exception('Error getting yes or no select options', 500, $exception);
        }
    }

    public function loadClearedNotClearedSelectOptions()
    {
        try {
            $result = $this->sp
                ->stored_procedure('pr_select_option_library_cleared_not_cleared_lst')
                ->stored_procedure_connection('iclearance_connection')
                ->execute();

            return $result->stored_procedure_result();
        } catch (Exception $exception) {
            throw new Exception('Error getting yes or no select options', 500, $exception);
        }
    }

    
}
