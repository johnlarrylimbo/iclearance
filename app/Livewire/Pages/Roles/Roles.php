<?php

namespace App\Livewire\Pages\Roles;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;

use Illuminate\Support\Facades\DB;

use App\Services\RoleService;

use Livewire\WithPagination;
use Mary\Traits\Toast;

use session;

#[Lazy]
#[Layout('layouts.app')]
class Roles extends Component
{

	use WithPagination;
	use Toast;

	protected $role_service;

	public bool $addRoleModal = false;
	public bool $editRoleModal = false;
	public bool $deleteRoleModal = false;

	public $role_id;

	public $description;
	public $edit_description;

	public function boot(
		RoleService $role_service,
	)
	{
		$this->role_service = $role_service;
	}

	// Load records from the database
	#[Computed]
	// public function loadRecords
	public function roles(){
		$roles = $this->role_service->loadRoles();
		return $roles->paginate(10);
	}

	public function mount(){
		// Initialize form fields
		$this->description = '';
	}

  public function save(){
		// Validation and saving logic
		$this->validate([
			'description' => 'required|string|max:255'
		]);

		// Check for duplicates
    $param = [  $this->description, 0 ];
    $sp_query = "EXEC pr_role_check_exists :label, :result_id;";
    $exists = DB::connection('iclearance_connection')->select($sp_query, $param);

		if ($exists[0]->result_id == 1) {
			// Toast
			$this->error('Record already exists.');
		}
		else{
      $param = [  $this->description, 0 ];
      $sp_query = "EXEC pr_role_ins :label, :result_id;";
      $result = DB::connection('iclearance_connection')->select($sp_query, $param);
			
      if ($result[0]->result_id > 0) {
        // Toast
        $this->success('Record added successfully!');
      }else{
        // Toast
        $this->success('Failed to add new role!');
      }
		}

		// Optionally reset form fields after save
		$this->reset(['description', 'description']);
		// Close the modal
		$this->addRoleModal  = false;

		$this->roles();
	}

	public function render(){
		return view('livewire.pages.roles.roles');
	}

}
