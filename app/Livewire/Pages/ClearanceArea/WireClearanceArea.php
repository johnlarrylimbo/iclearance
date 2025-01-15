<?php

namespace App\Livewire\Pages\ClearanceArea;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;

use Illuminate\Support\Facades\DB;

use App\Models\ClearanceArea;

use App\Services\ClearanceAreaService;
use App\Services\SelectOptionLibraryService;

use Livewire\WithPagination;
use Mary\Traits\Toast;

use session;

#[Lazy]
#[Layout('layouts.app')]
class WireClearanceArea extends Component
{

	use WithPagination;
	use Toast;

	protected $clearance_area_service;
  protected $select_option_library_service;

	public bool $addClearanceAreaModal = false;
	public bool $editClearanceAreaModal = false;
	public bool $deleteClearanceAreaModal = false;

	public $clearance_area_id;

	public $parent_clearance_area_id;
  public $abbreviation;
  public $description;
  public $sort;
  public $order_type_id;
  public $is_student_clearance_area;
  public $is_employee_clearance_area;
  public $is_clearance_area_default_cleared;

  public $edit_parent_clearance_area_id;
  public $edit_abbreviation;
  public $edit_description;
  public $edit_sort;
  public $edit_order_type_id;
  public $edit_is_student_clearance_area;
  public $edit_is_employee_clearance_area;
  public $edit_is_clearance_area_default_cleared;

  public $search;

	public function boot(
		ClearanceAreaService $clearance_area_service,
    SelectOptionLibraryService $select_option_library_service,
	)
	{
		$this->clearance_area_service = $clearance_area_service;
    $this->select_option_library_service = $select_option_library_service;
	}

	// Load records from the database
	#[Computed]
	// public function loadRecords
	public function clearance_area(){
    if(!$this->search){
      $clearance_area = $this->clearance_area_service->loadClearanceArea()->paginate(10);
		  return $clearance_area;
    }else{
      $clearance_area = $this->clearance_area_service->searchClearanceAreaByKeyword($this->search)->paginate(10);
		  return $clearance_area;
    }
	}

  #[Computed]
	// public function loadHealthClaimCategoryOptions()
	public function parent_clearance_area_options(){
		return $this->select_option_library_service->loadClearanceAreaOptions();
	}

  #[Computed]
	// public function loadHealthClaimCategoryOptions()
	public function sorting_numbers_options(){
		return $this->select_option_library_service->loadSortingNumbers();
	}

  #[Computed]
	// public function loadHealthClaimCategoryOptions()
	public function yes_or_no_options(){
		return $this->select_option_library_service->loadYesNoSelectOptions();
	}

  #[Computed]
	// public function loadHealthClaimCategoryOptions()
	public function cleared_not_cleared_options(){
		return $this->select_option_library_service->loadClearedNotClearedSelectOptions();
	}

  #[Computed]
	// public function loadHealthClaimCategoryOptions()
	public function order_type_options(){
		return $this->select_option_library_service->loadOrderTypeOptions();
	}

	public function mount(){
		// Initialize form fields
    $this->parent_clearance_area_id = 0;
		$this->abbreviation = '';
    $this->description = '';
    $this->sort = 0;
    $this->order_type_id = 0;
    $this->is_student_clearance_area = 0;
    $this->is_employee_clearance_area = 0;
    $this->is_clearance_area_default_cleared = 0;
	}

  public function save(){
		// Validation and saving logic
		$this->validate([
			'abbreviation' => 'required|string|max:25',
      'description' => 'required|string|max:512',
      'sort' => 'required',
      'order_type_id' => 'required',
      'is_student_clearance_area' => 'required',
      'is_employee_clearance_area' => 'required',
      'is_clearance_area_default_cleared' => 'required'
		]);

		// Check for duplicates
    $param = [  $this->abbreviation, $this->description, 0 ];
    $sp_query = "EXEC pr_clearance_area_check_exists :abbreviation, :description, :result_id;";
    $exists = DB::connection('iclearance_connection')->select($sp_query, $param);

		if ($exists[0]->result_id == 1) {
			$this->error('Record already exists.');
		}
		else{
      $param = [  $this->parent_clearance_area_id, $this->abbreviation, $this->description, $this->sort, $this->order_type_id, $this->is_student_clearance_area, $this->is_employee_clearance_area, $this->is_clearance_area_default_cleared, 0 ];
      $sp_query = "EXEC pr_clearance_area_ins :parent_clearance_area_id, :abbreviation, :description, :sort, :order_type_id, :is_student_clearance_area, :is_employee_clearance_area, :is_clearance_area_default_cleared, :result_id;";
      $result = DB::connection('iclearance_connection')->select($sp_query, $param);
			
      // Toast
      if ($result[0]->result_id > 0) {
        $this->success('Record added successfully!');
      }else{
        $this->success('Failed to add new role!');
      }
		}

		// Optionally reset form fields after save
		$this->reset(['parent_clearance_area_id', 'parent_clearance_area_id']);
    $this->reset(['abbreviation', 'abbreviation']);
    $this->reset(['description', 'description']);
    $this->reset(['sort', 'sort']);
    $this->reset(['order_type_id', 'edit_sort']);
    $this->reset(['is_student_clearance_area', 'is_student_clearance_area']);
    $this->reset(['is_employee_clearance_area', 'is_employee_clearance_area']);
    $this->reset(['is_clearance_area_default_cleared', 'is_clearance_area_default_cleared']);
		// Close the modal
		$this->addClearanceAreaModal  = false;

		$this->clearance_area();
	}

  // public function get records by id
	public function openEditClearanceAreaModal(int $clearance_area_id){
		$this->editClearanceAreaModal = true;
		$this->clearance_area_id = $clearance_area_id;

    $param = [  $clearance_area_id ];
    $sp_query = "EXEC pr_clearance_area_by_id_sel :clearance_area_id;";
    $result = DB::connection('iclearance_connection')->select($sp_query, $param);

		foreach($result as $result){
			$this->edit_parent_clearance_area_id = $result->parent_clearance_area_id;
      $this->edit_abbreviation = $result->abbreviation;
      $this->edit_description = $result->label;
      $this->edit_sort = $result->sort;
      $this->edit_order_type_id = $result->order_type_id;
      $this->edit_is_student_clearance_area = $result->is_student_clearance_area;
      $this->edit_is_employee_clearance_area = $result->is_employee_clearance_area;
      $this->edit_is_clearance_area_default_cleared = $result->default_cleared;
		}
	}

  public function save_edit(){
		// Validation and saving logic
		$this->validate([
			'edit_abbreviation' => 'required|string|max:25',
      'edit_description' => 'required|string|max:512',
      'edit_sort' => 'required',
      'edit_order_type_id' => 'required',
      'edit_is_student_clearance_area' => 'required',
      'edit_is_employee_clearance_area' => 'required',
      'edit_is_clearance_area_default_cleared' => 'required'
		]);

		// Check for duplicates
    $param = [  $this->clearance_area_id, 0 ];
    $sp_query = "EXEC pr_clearance_area_check_exists_by_id :clearance_area_id, :result_id;";
    $exists = DB::connection('iclearance_connection')->select($sp_query, $param);

		if ($exists[0]->result_id == 0) {
			// Toast
			$this->error('Record does not exists.');
		}
		else{
      $param = [  $this->clearance_area_id, $this->edit_parent_clearance_area_id, $this->edit_abbreviation, $this->edit_description, $this->edit_sort, $this->edit_order_type_id, $this->edit_is_student_clearance_area, $this->edit_is_employee_clearance_area, $this->edit_is_clearance_area_default_cleared, 0 ];
      $sp_query = "EXEC pr_clearance_area_by_id_upd :clearance_area_id, :parent_clearance_area_id, :abbreviation, :description, :sort, :order_type_id, :is_student_clearance_area, :is_employee_clearance_area, :is_clearance_area_default_cleared, :result_id;";
      $result = DB::connection('iclearance_connection')->select($sp_query, $param);
			
      // Toast
      if ($result[0]->result_id > 0) {
        $this->success('Record updated successfully!');
      }else{
        $this->success('Failed to update clearance area. Please try again later.');
      }
		}

		// Optionally reset form fields after save
		$this->reset(['clearance_area_id', 'clearance_area_id']);
    $this->reset(['edit_parent_clearance_area_id', 'edit_parent_clearance_area_id']);
    $this->reset(['edit_abbreviation', 'edit_abbreviation']);
    $this->reset(['edit_description', 'edit_description']);
    $this->reset(['edit_sort', 'edit_sort']);
    $this->reset(['edit_order_type_id', 'edit_sort']);
    $this->reset(['edit_is_student_clearance_area', 'edit_is_student_clearance_area']);
    $this->reset(['edit_is_employee_clearance_area', 'edit_is_employee_clearance_area']);
    $this->reset(['edit_is_clearance_area_default_cleared', 'edit_is_clearance_area_default_cleared']);

		// Close the modal
		$this->editClearanceAreaModal  = false;

		$this->clearance_area();
	}

  public function openDeleteClearanceAreaModal(int $clearance_area_id){
		$this->deleteClearanceAreaModal = true;
		$this->clearance_area_id = $clearance_area_id;
	}

	public function delete($clearance_area_id){
    $param = [  $clearance_area_id, 0 ];
    $sp_query = "EXEC pr_clearance_area_by_id_del :clearance_area_id, :result_id;";
    $result = DB::connection('iclearance_connection')->select($sp_query, $param);
		
		// Toast
    if ($result[0]->result_id > 0) {
      $this->success('Record deleted successfully!');
    }else{
      $this->error('Failed to remove clearance area. Clearance area might be used by other records or please try again later.');
    }

		$this->reset('clearance_area_id');
		$this->deleteClearanceAreaModal = false;	
	}


	public function render(){
		return view('livewire.pages.clearance-area.clearance-area');
	}

}
