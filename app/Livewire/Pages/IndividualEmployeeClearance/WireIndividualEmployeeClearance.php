<?php

namespace App\Livewire\Pages\IndividualEmployeeClearance;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

use Illuminate\Support\Facades\DB;

use App\Services\IndividualEmployeeClearanceService;

use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Lazy]
#[Layout('layouts.app')]
class WireIndividualEmployeeClearance extends Component
{
  use Toast;
  use WithPagination;


	protected $individual_employee_clearance_service;

  public $search = '';
	// public $search;

	public function boot(
		IndividualEmployeeClearanceService $individual_employee_clearance_service,
	)
	{
		$this->individual_employee_clearance_service = $individual_employee_clearance_service;
	}

	public function mount(){
		// Initialize form fields
		// if (session()->has('clearance_id')) {
		// 	$this->clearance_id = session('clearance_id');
		// } else {
		// 		// Set default value or take an action
		// 		$this->clearance_id = 0; // or some default value
		// }
	}

  // Load records from the database
	#[Computed]
	public function individual_employee_clearance_detail(){
    $individual_employee_clearance_detail = $this->individual_employee_clearance_service->searchIndividualEmployeeClearanceByKeyword($this->search)->paginate(10);
		return $individual_employee_clearance_detail;
	}

	// public function updatedSearch()
	// {
	// 		// Reset pagination when the search term is updated
	// 		$this->resetPage();
	// }

	// Load records from the database
	


	public function render()
	{
			return view('livewire.pages.individual-employee-clearance.individual-employee-clearance');
	}
}
