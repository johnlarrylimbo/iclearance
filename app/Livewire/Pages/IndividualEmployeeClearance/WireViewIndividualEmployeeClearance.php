<?php

namespace App\Livewire\Pages\IndividualEmployeeClearance;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Services\EmployeeService;
use App\Services\EmployeeClearanceService;

use Livewire\WithPagination;
use Mary\Traits\Toast;

use session;

#[Lazy]
#[Layout('layouts.app')]
class WireViewIndividualEmployeeClearance extends Component
{
  use Toast;
  use WithPagination;

  public $employee_id = 0;

  public string $selectedTab = 'clearance-1';


	protected $employee_service;

  public $search = '';
	// public $search;

	public function boot(
		EmployeeService $employee_service,
    EmployeeClearanceService $employee_clearance_service,
	)
	{
		$this->employee_service = $employee_service;
    $this->employee_clearance_service = $employee_clearance_service;
	}

	public function mount(){
		// Initialize form fields
    if (session()->has('employee_id')) {
			$this->employee_id = session('employee_id');
		} else {
				// Set default value or take an action
				$this->employee_id = 0; // or some default value
		}
	}

  // Load records from the database
	#[Computed]
	public function employee_information(){
    $employee_information = $this->employee_service->loadEmployeeDetailByEmployeeId($this->employee_id);
		return $employee_information;
	}

  // Load records from the database
	#[Computed]
	public function employee_active_clearance_lst(){
    $employee_active_clearance_lst = $this->employee_clearance_service->GetActiveEmployeeClearanceByEmployeeId($this->employee_id);
		return $employee_active_clearance_lst;
	}

  // Load records from the database
	#[Computed]
	public function employee_active_clearance_detail_lst(){
    $employee_active_clearance_detail_lst = $this->employee_clearance_service->GetActiveEmployeeClearanceDetailByAuthorizedEmployeeId($this->employee_id, auth()->user()->user_account_id);
		return $employee_active_clearance_detail_lst;
	}
	
	public function update_clearance_detail_status($clearance_detail_area_id, $status){
		return $this->employee_clearance_service->UpdateEmployeeClearanceAreaDetailStatus($clearance_detail_area_id, $status, auth()->user()->user_account_id);

		$this->employee_active_clearance_detail_lst();
	}


	public function render()
	{
			return view('livewire.pages.individual-employee-clearance.view-individual-employee-clearance');
	}
}
