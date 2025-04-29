<?php

namespace App\Livewire\Pages\MyClearance;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;

use Illuminate\Support\Facades\DB;

use App\Services\MyClearanceService;

use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Lazy]
#[Layout('layouts.app')]
class WireMyClearance extends Component
{
  use Toast;
  use WithPagination;

	protected $my_clearance_service;

	public $clearance_id;

	public $search;

	public function boot(
		MyClearanceService $my_clearance_service,
	)
	{
		$this->my_clearance_service = $my_clearance_service;
	}

	// Load records from the database
	#[Computed]
	public function my_clearance_lst(){
		if(!$this->search){
      $my_clearance_lst = $this->my_clearance_service->loadMyClearanceLst(auth()->user()->user_account_id)->paginate(10);
		  return $my_clearance_lst;
    }else{
      $my_clearance_lst = $this->my_clearance_service->searchMyClearanceLstByKeyword($this->search, auth()->user()->user_account_id)->paginate(10);
		  return $my_clearance_lst;
    }
	}

	public function mount(){
		// Initialize form fields
	}

	public function openClearanceDetailWindow($clearance_detail_id)
	{ 
		session()->put('clearance_detail_id', $clearance_detail_id);
		// $this->redirect(route('employee.clearance', ['clearance_id' => $clearance_id]), navigate: false);
		$this->redirect(route('my.clearance-detail'));
	}

	public function openClearanceEmployeeEnrollmentWindow($clearance_id)
	{ 
		$this->redirect(route('clearance.employee-enrollment', ['clearance_id' => $clearance_id]), navigate: false);
	}


	public function render()
	{
			return view('livewire.pages.my-clearance.my-clearance');
	}
}
