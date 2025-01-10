<?php

namespace App\Services;

use Exception;

use MagsLabs\LaravelStoredProc\StoredProcedure as SP;

class RoleService extends Service
{
    protected SP $sp;

    public function __construct(SP $sp)
    {
        $this->sp = $sp;
    }
    //instantiate brand model class

    public function loadRoles()
    {
        try {
            $result = $this->sp
                ->stored_procedure('pr_roles_lst')
                ->stored_procedure_connection('iclearance_connection')
                ->execute();

            return $result->stored_procedure_result();
        } catch (Exception $exception) {
            throw new Exception('Error getting roles', 500, $exception);
        }
    }

    public function checkExists(string $description, int $result_id)
    {
        try {
            $result = $this->sp
                ->stored_procedure('pr_role_check_exists')
                ->stored_procedure_params(['?,?'])
                ->stored_procedure_values([$description, $result_id])
                ->stored_procedure_connection('iclearance_connection')
                ->execute();

            return $result->stored_procedure_result();
        } catch (Exception $exception) {
            throw new Exception('Error checking roles', 500, $exception);
        }
    }
    
}
