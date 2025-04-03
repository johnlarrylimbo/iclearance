<?php

namespace App\Livewire\Pages\ClearanceEmployeeEnrollment;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

use Illuminate\Support\Facades\DB;

use App\Services\ClearanceEmployeeEnrollmentService;
use App\Services\EmployeeService;

use Livewire\WithPagination;
use Mary\Traits\Toast;

use session;

#[Lazy]
#[Layout('layouts.app')]
class WireClearanceEmployeeEnrollment extends Component
{
  use Toast;
  use WithPagination;

	#[Url(as: 'clearance_id')]
	public $clearance_id = 0;

	public bool $PopulateEmployeeClearanceAreaModal = false;
	public $add_clearance_id;
	public $employee_id;
	public $employee_no;
	public $employee_name;
	public $email_address;
	public $department_code;

	protected $clearance_employee_enrollment_service;
	protected $employee_service;


	public $search;

	public function boot(
		ClearanceEmployeeEnrollmentService $clearance_employee_enrollment_service,
		EmployeeService $employee_service,
	)
	{
		$this->clearance_employee_enrollment_service = $clearance_employee_enrollment_service;
		$this->employee_service = $employee_service;
	}

	// Load records from the database
	#[Computed]
	public function employee_lst(){
		if(!$this->search){
      $employee_lst = $this->employee_service->loadEmployeeLst($this->clearance_id)->paginate(15);
		  return $employee_lst;
    }else{
      $employee_lst = $this->employee_service->searchEmployeeLstByKeyword($this->clearance_id, $this->search)->paginate(15);
		  return $employee_lst;
    }
	}

	public function mount(){
		// Initialize form fields
		$this->employee_no = '';
		$this->employee_name = '';
		$this->email_address = '';
		$this->department_code = '';
	}

	public function populate_employee_clearance_area($employee_id){
		$employee_detail = $this->employee_service->loadEmployeeDetailByEmployeeId($employee_id);

		foreach($employee_detail as $result){
			$employee_no = $result->employee_no;
			$employee_name = $result->employee_name;
			$email_address = $result->email_address;
			$department_code = $result->department_code;
		}
		
		$this->PopulateEmployeeClearanceAreaModal = true;

		$this->add_clearance_id = $this->clearance_id;
		$this->employee_id = $employee_id;

		$this->employee_no = $employee_no;
		$this->employee_name = $employee_name;
		$this->email_address = $email_address;
		$this->department_code = $department_code;
	}

	public function populate_clearance_area_details(){

		// Check for duplicates
		$exists = $this->clearance_employee_enrollment_service->checkEmployeeClearanceDetailByEmployeeClearanceId($this->clearance_id, $this->employee_id);

		if ($exists[0]->result_id = 0) {
			// Toast
			$this->error('Record does not exists.');
		}
		else{
			$exists = $this->clearance_employee_enrollment_service->populateEmployeeClearanceDetailByEmployeeClearanceId($this->clearance_id, $this->employee_id, auth()->user()->user_account_id);
			// Flash success message
			$this->success('Record updated successfully!');
		}

		// Optionally reset form fields after save
		$this->reset(['add_clearance_id', 'add_clearance_id']);
    $this->reset(['employee_id', 'employee_id']);
		$this->reset(['employee_no', 'employee_no']);
		$this->reset(['employee_name', 'employee_name']);
		$this->reset(['email_address', 'email_address']);
		$this->reset(['department_code', 'department_code']);

		// Close the modal
		$this->PopulateEmployeeClearanceAreaModal  = false;

		$this->employee_lst();
	}


	public function render()
	{
			return view('livewire.pages.clearance-employee-enrollment.clearance-employee-enrollment');
	}
}
