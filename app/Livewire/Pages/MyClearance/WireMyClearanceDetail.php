<?php

namespace App\Livewire\Pages\MyClearance;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Services\MyClearanceService;

use Livewire\WithPagination;
use Mary\Traits\Toast;

use session;

#[Lazy]
#[Layout('layouts.app')]
class WireMyClearanceDetail extends Component
{
  use Toast;
  use WithPagination;

  public $clearance_detail_id = 0;

  public string $selectedTab = 'clearance-1';


	protected $my_clearance_service;

  public $search = '';
	// public $search;

	public function boot(
		MyClearanceService $my_clearance_service,
	)
	{
		$this->my_clearance_service = $my_clearance_service;
	}

	public function mount(){
		// Initialize form fields
    if (session()->has('clearance_detail_id')) {
			$this->clearance_detail_id = session('clearance_detail_id');
		} else {
				// Set default value or take an action
				$this->clearance_detail_id = 0; // or some default value
		}
	}

  // Load records from the database
	#[Computed]
	public function my_clearance_detail(){
    $my_clearance_detail = $this->my_clearance_service->loadMyClearanceDetailByClearanceDetailId($this->clearance_detail_id);
		return $my_clearance_detail;
	}

  // // Load records from the database
	// #[Computed]
	// public function employee_active_clearance_lst(){
  //   $employee_active_clearance_lst = $this->my_clearance_service->GetActiveEmployeeClearanceByEmployeeId($this->employee_id);
	// 	return $employee_active_clearance_lst;
	// }

  // // Load records from the database
	// #[Computed]
	// public function employee_active_clearance_detail_lst(){
  //   $employee_active_clearance_detail_lst = $this->employee_clearance_service->GetActiveEmployeeClearanceDetailByAuthorizedEmployeeId($this->employee_id, auth()->user()->user_account_id);
	// 	return $employee_active_clearance_detail_lst;
	// }
	
	// public function update_clearance_detail_status($clearance_detail_area_id, $status){
	// 	return $this->employee_clearance_service->UpdateEmployeeClearanceAreaDetailStatus($clearance_detail_area_id, $status, auth()->user()->user_account_id);

	// 	$this->employee_active_clearance_detail_lst();
	// }


	public function render()
	{
			return view('livewire.pages.my-clearance.my-clearance-detail');
	}
}
