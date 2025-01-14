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

    public function searchRolesByKeyword(string $search_query)
    {
			try {
        $search = $search_query ?? '';       
					$result = $this->sp
										->stored_procedure('pr_role_by_search_lst')
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
