<?php

namespace App\Livewire\Pages\ClearancePages;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;

use Illuminate\Support\Facades\DB;

use App\Services\ClearanceService;
use App\Services\ClearanceAreaItemService;
use App\Services\ClearanceDetailService;
use App\Services\AuthEmployeeService;

use Livewire\WithPagination;
use Mary\Traits\Toast;

use session;
use Auth;

#[Lazy]
#[Layout('layouts.app')]
class WireClearanceFacultyHed extends Component
{

	use WithPagination;
	use Toast;

	protected $clearance_service;
	protected $clearance_area_item_service;
	protected $clearance_detail_service;
	protected $auth_employee_service;

	public bool $showClearanceAreaItemModal = false;
	public bool $showClearanceEmployeeRecordModal = false;
	public bool $showEmployeeClearanceRecordModal = false;

	public $clearance_id;
	public $clearance_detail_id;
	public $clearance_detail_area_id;

  public $edit_description;

	public $title;
	public $employee_clearance_title;

  public $search;	
	public $search_employee;	

	public $param_clearance_id = 0;	
	public $param_clearance_detail_id = 0;	

	public function boot(
		ClearanceService $clearance_service,
		ClearanceAreaItemService $clearance_area_item_service,
		ClearanceDetailService $clearance_detail_service,
		AuthEmployeeService $auth_employee_service,
	)
	{
		$this->clearance_service = $clearance_service;
		$this->clearance_area_item_service = $clearance_area_item_service;
		$this->clearance_detail_service = $clearance_detail_service;
		$this->auth_employee_service = $auth_employee_service;
	}

	// Load records from the database
	#[Computed]
	public function clearance(){
		// $clearance = $this->clearance_service->loadClearance();
		// return $clearance->paginate(10);
    if(!$this->search){
			$clearance = $this->clearance_service->loadClearanceFacultyHigherEducation()->paginate(10);
			return $clearance;
		}
		else{
			$clearance = $this->clearance_service->searchClearanceFacultyHigherEducationByKeyword($this->search)->paginate(10);
			return $clearance;
		}
	}

  #[Computed]
	public function period_semester_options(){
		return $this->period_semester_service->loadPeriodSemesterOptions();
	}

	public function mount(){
		// Initialize form fields
    // $this->clearance_id = 0;

	}
	
	public function openClearanceAreaItemModal(int $clearance_id){
		$this->showClearanceAreaItemModal = true;

		$param = [  $clearance_id ];
    $sp_query = "EXEC pr_clearance_by_id_sel :clearance_id;";
    $result = DB::connection('iclearance_connection')->select($sp_query, $param);

		foreach($result as $result){
      $this->title = $result->description;
		}
		
		$this->param_clearance_id = $clearance_id;
	}

	// Load records from the database
	#[Computed]
	public function clearance_area_item_by_clearance_id(){
		$clearance_area_item_by_clearance_id = $this->clearance_area_item_service->searchClearanceAreaItemByClearanceId($this->param_clearance_id);
		return $clearance_area_item_by_clearance_id;
	}

	public function openClearanceEmployeeRecordModal(int $clearance_id){
		$this->showClearanceEmployeeRecordModal = true;

		$param = [  $clearance_id ];
    $sp_query = "EXEC pr_clearance_by_id_sel :clearance_id;";
    $result = DB::connection('iclearance_connection')->select($sp_query, $param);

		foreach($result as $result){
      $this->title = $result->description;
		}
		// $this->title = 'Post title...';
		$this->param_clearance_id = $clearance_id;
	}

	// Load records from the database
	#[Computed]
	public function clearance_employee_record_by_clearance_id(){
		if(!$this->search_employee){
			$clearance_employee_record_by_clearance_id = $this->clearance_service->getClearanceEmployeeRecordByClearanceId($this->param_clearance_id)->paginate(10);
			return $clearance_employee_record_by_clearance_id;
		}
		else{
			$clearance_employee_record_by_clearance_id = $this->clearance_service->getClearanceEmployeeRecordByKeywordClearanceId($this->param_clearance_id, $this->search_employee)->paginate(10);
			return $clearance_employee_record_by_clearance_id;
		}
	}

	public function openEmployeeClearanceRecordModal(int $clearance_detail_id){
		$this->showEmployeeClearanceRecordModal = true;
		$this->param_clearance_detail_id = $clearance_detail_id;

		$param = [  $clearance_detail_id ];
    $sp_query = "EXEC pr_clearance_detail_employee_by_clearance_id_sel :clearance_detail_id;";
    $result = DB::connection('iclearance_connection')->select($sp_query, $param);

		foreach($result as $result){
      $this->employee_clearance_title = $result->employee_name;
		}
	}

	// Load records from the database
	#[Computed]
	public function employee_clearance_area_item_by_detail_id(){
		$employee_clearance_area_item_by_detail_id = $this->clearance_detail_service->getEmployeeClearanceAreaItemByDetailId($this->param_clearance_detail_id, auth()->user()->user_account_id);
		return $employee_clearance_area_item_by_detail_id;
	}

	public function update_clearance_detail_area_status($clearance_detail_area_id){
    $param = [  $clearance_detail_area_id, auth()->user()->user_account_id, 0 ];
    $sp_query = "EXEC pr_clearance_detail_area_status_by_id_upd :clearance_detail_area_id, :account_id, :result_id;";
    $result = DB::connection('iclearance_connection')->select($sp_query, $param);

		$this->reset('clearance_detail_area_id');
	}

	public function render(){
		return view('livewire.pages.clearance-pages.clearance-faculty-hed');
	}

}
