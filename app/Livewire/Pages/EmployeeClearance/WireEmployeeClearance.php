<?php

namespace App\Livewire\Pages\EmployeeClearance;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

use Illuminate\Support\Facades\DB;

use App\Services\EmployeeClearanceService;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmployeeClearanceAreaStatusUpdateMailer;

use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Lazy]
#[Layout('layouts.app')]
class WireEmployeeClearance extends Component
{
  use Toast;
  use WithPagination;

	// #[Url(as: 'clearance_id')]
	public $clearance_id = 0;
	public $clearance_detail_id;

	// $clearanceId = session('clearance_id');
	public bool $updateClearanceDetailAreaModal = false;


	protected $employee_clearance_service;


	public $search;

	public $items = [];
	public $expandedRowId = null;

	public function toggleRow($resultId)
	{
		session()->put('clearance_detail_id', $resultId);
		$this->expandedRowId = $this->expandedRowId === $resultId ? null : $resultId;
	}

	public function boot(
		EmployeeClearanceService $employee_clearance_service,
	)
	{
		$this->employee_clearance_service = $employee_clearance_service;
	}

	public function mount(){
		// Initialize form fields
		if (session()->has('clearance_id')) {
			$this->clearance_id = session('clearance_id');
		} else {
				// Set default value or take an action
				$this->clearance_id = 0; // or some default value
		}
		$clearance_detail_id = 0;
		// if (session()->has('clearance_detail_id')) {
		// 	$this->clearance_detail_id = session('clearance_detail_id');
		// } else {
		// 		// Set default value or take an action
		// 		$this->clearance_detail_id = 0; // or some default value
		// }
	}

	public function updatedSearch()
	{
			// Reset pagination when the search term is updated
			$this->resetPage();
	}

	// Load records from the database
	#[Computed]
	public function employee_clearance_lst(){
		if(!$this->search){
      $employee_clearance_lst = $this->employee_clearance_service->loadEmployeeClearanceLst($this->clearance_id)->paginate(10);
		  return $employee_clearance_lst;
    }else{
      $employee_clearance_lst = $this->employee_clearance_service->searchEmployeeClearanceLstByClearanceIdKeyword($this->clearance_id, $this->search)->paginate(10);
		  return $employee_clearance_lst;
    }
	}

	#[Computed]
	// public function loadHealthClaimCategoryOptions()
	public function employee_clearance_detail(){
		$employee_clearance_detail = $this->employee_clearance_service->EmployeeClearanceByClearanceId($this->clearance_id);
		return $employee_clearance_detail;
	}

	#[Computed]
	// public function loadHealthClaimCategoryOptions()
	public function clearance_area_lst(){
		return $this->employee_clearance_service->loadEmployeeClearanceAreaByClearanceIdLst($this->clearance_id);
	}

	#[Computed]
	// public function loadHealthClaimCategoryOptions()
	public function clearance_area_by_clearance_detail_id_lst(){
		return $this->employee_clearance_service->loadEmployeeClearanceAreaByClearanceDetailIdLst(session('clearance_detail_id'));
	}

	#[Computed]
	// public function loadHealthClaimCategoryOptions()
	public function loaded_employee_clearance_area(){
		return $this->employee_clearance_service->loadedEmployeeClearanceAreaByClearanceId($this->clearance_id);
	}


	

	public function update_area_status($clearance_detail_area_id, $status){
		// DB::select('CALL sp_brand_del(?)', [ $id ]);
		// // Flash success message
		// $this->message_type = 'deleted';
		// $this->message = 'Record deleted successfully!';

		// $this->loadRecords();
		return $this->employee_clearance_service->UpdateEmployeeClearanceAreaDetailStatus($clearance_detail_area_id, $status, auth()->user()->user_account_id);
		// dd("Input updated: " . $clearance_detail_id);

		// $details = [
		// 	'name' => 'John Larry',
		// 	'email' => 'jlimbo@uic.edu.ph',
		// 	'message' => 'Test message only.',
		// ];

		// Mail::to('jlimbo@uic.edu.ph')->send(new EmployeeClearanceAreaStatusUpdateMailer($details));

		// // session()->flash('success', 'Email sent successfully!');
		// $this->reset();

		$this->employee_clearance_lst();
	}



	


	public function render()
	{
			return view('livewire.pages.employee-clearance.employee-clearance');
	}
}
