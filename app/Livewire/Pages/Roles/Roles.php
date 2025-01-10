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

	public function render(){
		return view('livewire.pages.roles.roles');
	}

}
