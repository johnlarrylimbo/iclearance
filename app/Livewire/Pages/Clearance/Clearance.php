<?php

namespace App\Livewire\Pages\Clearance;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;

use Illuminate\Support\Facades\DB;

use App\Services\ClearanceService;
use App\Services\PeriodTypeService;
use App\Services\PeriodSemesterService;
use App\Services\PeriodAcademicYearService;
use App\Services\ClearanceTypeService;
use App\Services\SelectOptionLibraryService;

use Livewire\WithPagination;
use Mary\Traits\Toast;

use session;
use Auth;

#[Lazy]
#[Layout('layouts.app')]
class Clearance extends Component
{

	use WithPagination;
	use Toast;

	protected $clearance_service;
  protected $period_type_service;
  protected $period_semester_service;
  protected $period_academic_year_service;
  protected $clearance_type_service;
  protected $select_option_library_service;

  public bool $addClearancePeriodTypeModal = false;
	public bool $addSemesterClearanceModal = false;
  public bool $addAnnualClearanceModal = false;
	public bool $editClearanceModal = false;
	public bool $deleteClearanceModal = false;
  public bool $addClearanceAreaRecordModal = false;
  public bool $addClearanceEmployeeRecordModal = false;
  public bool $populateClearanceEmployeeClearanceDetailModal = false;

	public $clearance_id;

	public $period_type_id;
  public $period_id;
  public $clearance_type_id;
  public $description;
  public $is_open;	

  public $edit_description;
  public $edit_is_open;	

  public $clearance_area_item_id;
  public $clearance_employee_id;


	public function boot(
		ClearanceService $clearance_service,
    PeriodTypeService $period_type_service,
    PeriodSemesterService $period_semester_service,
    PeriodAcademicYearService $period_academic_year_service,
    ClearanceTypeService $clearance_type_service,
    SelectOptionLibraryService $select_option_library_service,
	)
	{
		$this->clearance_service = $clearance_service;
    $this->period_type_service = $period_type_service;
    $this->period_semester_service = $period_semester_service;
    $this->period_academic_year_service = $period_academic_year_service;
    $this->clearance_type_service = $clearance_type_service;
    $this->select_option_library_service = $select_option_library_service;
	}

	// Load records from the database
	#[Computed]
	public function clearance(){
		$clearance = $this->clearance_service->loadClearance();
		return $clearance->paginate(10);
	}

  #[Computed]
	public function period_type_options(){
		return $this->period_type_service->loadPeriodType();
	}

  #[Computed]
	public function period_semester_options(){
		return $this->period_semester_service->loadPeriodSemesterOptions();
	}

  #[Computed]
	public function period_academic_year_options(){
		return $this->period_academic_year_service->loadPeriodAcademicYearOptions();
	}

  #[Computed]
	public function clearance_type_options(){
		return $this->clearance_type_service->loadClearanceType();
	}

  #[Computed]
	public function select_option_library_options(){
		return $this->select_option_library_service->loadOpenClosedSelectOptions();
	}

  #[Computed]
	public function cleared_not_cleared_select_options(){
		return $this->select_option_library_service->loadClearedNotClearedSelectOptions();
	}

  #[Computed]
	public function clearance_area_item_select_options(){
		return $this->select_option_library_service->loadClearanceAreaItemSelectOptions();
	}

  #[Computed]
	public function clearance_employee_select_options(){
		return $this->select_option_library_service->loadClearanceEmployeeSelectOptions();
	}

	public function mount(){
		// Initialize form fields
    $this->period_type_id = 0;
    $this->period_id = 0;
    $this->clearance_type_id = 0;
    $this->description = '';
    $this->is_open = 0;

    $this->clearance_area_item_id = [];
    $this->clearance_employee_id = [];

	}

  public function save_period_type(){
		// Validation and saving logic
		$this->validate([
      'period_type_id' => 'required|not_in:0',
		]);

    $param = [ $this->period_type_id ];
    $sp_query = "EXEC pr_period_type_by_id_sel :period_type_id;";
    $result = DB::connection('iclearance_connection')->select($sp_query, $param);

    foreach($result as $result){
			$period_type_id = $result->period_type_id;
      $label = $result->label;
		}

    if($period_type_id == 1){
      $this->addSemesterClearanceModal  = true;
      $this->period_type_id = $this->period_type_id;
    }
    else{
      $this->addAnnualClearanceModal  = true;
      $this->period_type_id = $this->period_type_id;
    }

    $this->addClearancePeriodTypeModal  = false;

	}

  public function save_semestral_clearance(){
		// Validation and saving logic
		$this->validate([
			'period_type_id' => 'required|integer||not_in:0',
      'period_id' => 'required|integer||not_in:0',
      'clearance_type_id' => 'required||integer||not_in:0',
      'description' => 'required|string|max:512',
      'is_open' => 'required|integer||not_in:0'
		]);

		// Check for duplicates
    $param = [  $this->period_id, $this->clearance_type_id, $this->description, 0 ];
    $sp_query = "EXEC pr_clearance_check_exists :period_id, :clearance_type_id, :description, :result_id;";
    $exists = DB::connection('iclearance_connection')->select($sp_query, $param);

		if ($exists[0]->result_id == 1) {
			$this->error('Record already exists.');
		}
		else{
      $param = [  $this->period_type_id, $this->period_id, $this->clearance_type_id, $this->description, $this->is_open, 0 ];
      $sp_query = "EXEC pr_clearance_ins :period_type_id, :period_id, :clearance_type_id, :description, :is_open, :result_id;";
      $result = DB::connection('iclearance_connection')->select($sp_query, $param);
			
      // Toast
      if ($result[0]->result_id > 0) {
        $this->success('Clearance ecord added successfully!');
      }else{
        $this->success('Failed to add new clearance. Please try again later!');
      }
		}

		// Optionally reset form fields after save
		$this->reset(['period_type_id', 'period_type_id']);
    $this->reset(['period_id', 'period_id']);
    $this->reset(['clearance_type_id', 'clearance_type_id']);
    $this->reset(['description', 'description']);
    $this->reset(['is_open', 'is_open']);
		// Close the modal
		$this->addSemesterClearanceModal  = false;

		$this->clearance();
	}

  public function save_annual_clearance(){
		// Validation and saving logic
		$this->validate([
			'period_type_id' => 'required|integer||not_in:0',
      'period_id' => 'required|integer||not_in:0',
      'clearance_type_id' => 'required||integer||not_in:0',
      'description' => 'required|string|max:512',
      'is_open' => 'required|integer||not_in:0'
		]);

		// Check for duplicates
    $param = [  $this->period_id, $this->clearance_type_id, $this->description, 0 ];
    $sp_query = "EXEC pr_clearance_check_exists :period_id, :clearance_type_id, :description, :result_id;";
    $exists = DB::connection('iclearance_connection')->select($sp_query, $param);

		if ($exists[0]->result_id == 1) {
			$this->error('Record already exists.');
		}
		else{
      $param = [  $this->period_type_id, $this->period_id, $this->clearance_type_id, $this->description, $this->is_open, 0 ];
      $sp_query = "EXEC pr_clearance_ins :period_type_id, :period_id, :clearance_type_id, :description, :is_open, :result_id;";
      $result = DB::connection('iclearance_connection')->select($sp_query, $param);
			
      // Toast
      if ($result[0]->result_id > 0) {
        $this->success('Clearance ecord added successfully!');
      }else{
        $this->success('Failed to add new clearance. Please try again later!');
      }
		}

		// Optionally reset form fields after save
		$this->reset(['period_type_id', 'period_type_id']);
    $this->reset(['period_id', 'period_id']);
    $this->reset(['clearance_type_id', 'clearance_type_id']);
    $this->reset(['description', 'description']);
    $this->reset(['is_open', 'is_open']);
		// Close the modal
		$this->addAnnualClearanceModal  = false;

		$this->clearance();
	}

  // public function get records by id
	public function openEditClearanceModal(int $clearance_id){
		$this->editClearanceModal = true;
		$this->clearance_id = $clearance_id;

    $param = [  $clearance_id ];
    $sp_query = "EXEC pr_clearance_by_id_sel :clearance_id;";
    $result = DB::connection('iclearance_connection')->select($sp_query, $param);

		foreach($result as $result){
      $this->edit_description = $result->description;
      $this->edit_is_open = $result->is_open;
		}
	}

  public function save_edit(){
		// Validation and saving logic
		$this->validate([
      'edit_description' => 'required|string|max:512',
      'edit_is_open' => 'required|integer||not_in:0'
		]);

		// Check for duplicates
    $param = [  $this->clearance_id, 0 ];
    $sp_query = "EXEC pr_clearance_check_exists_by_id :clearance_id, :result_id;";
    $exists = DB::connection('iclearance_connection')->select($sp_query, $param);

		if ($exists[0]->result_id == 0) {
			// Toast
			$this->error('Record does not exists.');
		}
		else{
      $param = [  $this->clearance_id, $this->edit_description, $this->edit_is_open, 0 ];
      $sp_query = "EXEC pr_clearance_by_id_upd :clearance_id, :description, :is_open, :result_id;";
      $result = DB::connection('iclearance_connection')->select($sp_query, $param);
			
      // Toast
      if ($result[0]->result_id > 0) {
        $this->success('Record updated successfully!');
      }else{
        $this->success('Failed to update clearance area. Please try again later.');
      }
		}

		// Optionally reset form fields after save
		$this->reset(['clearance_id', 'clearance_id']);
    $this->reset(['edit_description', 'edit_description']);
    $this->reset(['edit_is_open', 'edit_is_open']);

		// Close the modal
		$this->editClearanceModal  = false;

		$this->clearance();
	}

  public function openDeleteClearanceModal(int $clearance_id){
		$this->deleteClearanceModal = true;
		$this->clearance_id = $clearance_id;
	}

	public function delete($clearance_id){
    $param = [  $clearance_id, 0 ];
    $sp_query = "EXEC pr_clearance_by_id_del :clearance_id, :result_id;";
    $result = DB::connection('iclearance_connection')->select($sp_query, $param);
		
		// Toast
    if ($result[0]->result_id > 0) {
      $this->success('Clearance record deleted successfully!');
    }else{
      $this->error('Failed to remove clearance. Clearance might be used by other records or please try again later.');
    }

		$this->reset('clearance_id');
		$this->deleteClearanceModal = false;	
	}

  // public function get records by id
	public function openAddClearanceAreaItemModal(int $clearance_id){
		$this->addClearanceAreaRecordModal = true;
		$this->clearance_id = $clearance_id;

    $clearance_area_item_ids = [];

    $param = [  $clearance_id ];
    $sp_query = "EXEC pr_clearance_area_item_by_id_sel :clearance_id;";
    $clearance_area_item = DB::connection('iclearance_connection')->select($sp_query, $param);

    foreach ($clearance_area_item as $result) {
			array_push($clearance_area_item_ids, $result->clearance_area_id);
		}

    $this->clearance_area_item_id = $clearance_area_item_ids;
	}

  public function save_clearance_area_record(){
		// Validation and saving logic
		$this->validate([
			'clearance_area_item_id' => 'required'
		]);

    $param = [  $this->clearance_id, 0 ];
    $sp_query = "EXEC pr_clearance_check_exists_by_id :clearance_id, :result_id;";
    $exists = DB::connection('iclearance_connection')->select($sp_query, $param);

    if ($exists[0]->result_id == 0) {
			// Toast
			$this->error('Record does not exists.');
		}
		else{

      $param = [  $this->clearance_id, 0 ];
      $sp_query = "EXEC pr_clearance_area_item_by_id_del :clearance_id, :result_id;";
      $result = DB::connection('iclearance_connection')->select($sp_query, $param);

      foreach ($this->clearance_area_item_id as $v) {
        $param = [ $this->clearance_id, $v, auth()->user()->user_account_id, 0 ];
        $sp_query = "EXEC pr_clearance_area_item_ins :clearance_id, :clearance_area_item_id, :account_id, :result_id;";
        $exists = DB::connection('iclearance_connection')->select($sp_query, $param);
      }
		
     	// Toast
			$this->success('Clearance area item added successfully!');
		}

		// Close the modal
		$this->addClearanceAreaRecordModal  = false;
	}

  public function openAddClearanceEmployeeModal(int $clearance_id){
		$this->addClearanceEmployeeRecordModal = true;
		$this->clearance_id = $clearance_id;

    $clearance_employee_ids = [];

    $param = [  $clearance_id ];
    $sp_query = "EXEC pr_clearance_employee_by_id_sel :clearance_id;";
    $clearance_area_item = DB::connection('iclearance_connection')->select($sp_query, $param);

    foreach ($clearance_area_item as $result) {
			array_push($clearance_employee_ids, $result->employee_id);
		}

    $this->clearance_employee_id = $clearance_employee_ids;
	}

  public function save_clearance_employee_record(){
		// Validation and saving logic
		$this->validate([
			'clearance_employee_id' => 'required'
		]);

    $param = [  $this->clearance_id, 0 ];
    $sp_query = "EXEC pr_clearance_check_exists_by_id :clearance_id, :result_id;";
    $exists = DB::connection('iclearance_connection')->select($sp_query, $param);

    if ($exists[0]->result_id == 0) {
			// Toast
			$this->error('Record does not exists.');
		}
		else{

      $param = [  $this->clearance_id, 0 ];
      $sp_query = "EXEC pr_clearance_employee_item_by_id_del :clearance_id, :result_id;";
      $result = DB::connection('iclearance_connection')->select($sp_query, $param);

      foreach ($this->clearance_employee_id as $v) {
        $param = [ $this->clearance_id, $v, auth()->user()->user_account_id, 0 ];
        $sp_query = "EXEC pr_clearance_employee_item_ins :clearance_id, :employee_id, :account_id, :result_id;";
        $exists = DB::connection('iclearance_connection')->select($sp_query, $param);
      }
		
     	// Toast
			$this->success('Clearance employee item added successfully!');
		}

		// Close the modal
		$this->addClearanceEmployeeRecordModal  = false;
	}

  public function openPopulateClearanceEmployeeClearanceDetailModal(int $clearance_id){
		$this->populateClearanceEmployeeClearanceDetailModal = true;
		$this->clearance_id = $clearance_id;
	}

  public function populate_employee_clearance_detail($clearance_id){
    $param = [  $clearance_id ];
    $sp_query = "EXEC pr_populate_clearance_employee_clearance_detail_by_id :clearance_id;";
    $result = DB::connection('iclearance_connection')->update($sp_query, $param);

    $param2 = [  $clearance_id, auth()->user()->user_account_id ];
    $sp_query2 = "EXEC pr_clearance_by_id_upd_populated_status :clearance_id, :account_id;";
    $result2 = DB::connection('iclearance_connection')->update($sp_query2, $param2);
		
		// Toast
      $this->success('Clearance employee clearande detail record populated successfully!');

		$this->reset('clearance_id');
		$this->populateClearanceEmployeeClearanceDetailModal = false;	
	}

	public function render(){
		return view('livewire.pages.clearance.clearance');
	}

}
