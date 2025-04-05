<?php

namespace App\Livewire\Pages\ClearanceManagement;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;

use Illuminate\Support\Facades\DB;

use App\Services\ClearanceManagementService;

use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Lazy]
#[Layout('layouts.app')]
class WireClearanceManagement extends Component
{
  use Toast;
  use WithPagination;

	protected $clearance_management_service;

	public $clearance_id;

	public $search;

	public function boot(
		ClearanceManagementService $clearance_management_service,
	)
	{
		$this->clearance_management_service = $clearance_management_service;
	}

	// Load records from the database
	#[Computed]
	public function clearance_lst(){
		if(!$this->search){
      $clearance_lst = $this->clearance_management_service->loadClearanceLst()->paginate(10);
		  return $clearance_lst;
    }else{
      $clearance_lst = $this->clearance_management_service->searchClearanceLstByKeyword($this->search)->paginate(10);
		  return $clearance_lst;
    }
	}

	public function mount(){
		// Initialize form fields
	}

	public function openClearanceDetailWindow($clearance_id)
	{ 
		session()->put('clearance_id', $clearance_id);
		// $this->redirect(route('employee.clearance', ['clearance_id' => $clearance_id]), navigate: false);
		$this->redirect(route('employee.clearance'));
	}

	public function openClearanceEmployeeEnrollmentWindow($clearance_id)
	{ 
		$this->redirect(route('clearance.employee-enrollment', ['clearance_id' => $clearance_id]), navigate: false);
	}


	public function render()
	{
			return view('livewire.pages.clearance-management.clearance-management');
	}
}
