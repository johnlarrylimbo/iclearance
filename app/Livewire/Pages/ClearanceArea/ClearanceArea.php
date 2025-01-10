<?php

namespace App\Livewire\Pages\ClearanceArea;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;

use Illuminate\Support\Facades\DB;

use App\Services\ClearanceAreaService;
use App\Services\SelectOptionLibraryService;

use Livewire\WithPagination;
use Mary\Traits\Toast;

use session;

#[Lazy]
#[Layout('layouts.app')]
class ClearanceArea extends Component
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
  public $is_student_clearance_area;
  public $is_employee_clearance_area;
  public $is_clearance_area_default_cleared;
	

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
		$clearance_area = $this->clearance_area_service->loadClearanceArea();
		return $clearance_area->paginate(10);
	}

  #[Computed]
	// public function loadHealthClaimCategoryOptions()
	public function parent_clearance_area_options(){
		return $this->clearance_area_service->loadClearanceAreaOptions();
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

	public function mount(){
		// Initialize form fields
    $this->parent_clearance_area_id = 0;
		$this->abbreviation = '';
    $this->description = '';
    $this->sort = 0;
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
      $param = [  $this->parent_clearance_area_id, $this->abbreviation, $this->description, $this->sort, $this->is_student_clearance_area, $this->is_employee_clearance_area, $this->is_clearance_area_default_cleared, 0 ];
      $sp_query = "EXEC pr_clearance_area_ins :parent_clearance_area_id, :abbreviation, :description, :sort, :is_student_clearance_area, :is_employee_clearance_area, :is_clearance_area_default_cleared, :result_id;";
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
    $this->reset(['is_student_clearance_area', 'is_student_clearance_area']);
    $this->reset(['is_employee_clearance_area', 'is_employee_clearance_area']);
    $this->reset(['is_clearance_area_default_cleared', 'is_clearance_area_default_cleared']);
		// Close the modal
		$this->addClearanceAreaModal  = false;

		$this->clearance_area();
	}

  // // public function get records by id
	// public function openEditRoleModal(int $role_id){
	// 	$this->editRoleModal = true;
	// 	$this->role_id = $role_id;

  //   $param = [  $role_id ];
  //   $sp_query = "EXEC pr_role_by_id_sel :role_id;";
  //   $result = DB::connection('iclearance_connection')->select($sp_query, $param);

	// 	foreach($result as $result){
	// 		$this->edit_description = $result->label;
	// 	}
	// }

  // public function save_edit(){
	// 	// Validation and saving logic
	// 	$this->validate([
	// 		'edit_description' => 'required|string|max:256'
	// 	]);

	// 	// Check for duplicates
  //   $param = [  $this->role_id, 0 ];
  //   $sp_query = "EXEC pr_role_check_exists_by_id :role_id, :result_id;";
  //   $exists = DB::connection('iclearance_connection')->select($sp_query, $param);

	// 	if ($exists[0]->result_id == 0) {
	// 		// Toast
	// 		$this->error('Record does not exists.');
	// 	}
	// 	else{
  //     $param = [  $this->role_id, $this->edit_description, 0 ];
  //     $sp_query = "EXEC pr_role_by_id_upd :role_id, :description, :result_id;";
  //     $result = DB::connection('iclearance_connection')->select($sp_query, $param);
			
  //     // Toast
  //     if ($result[0]->result_id > 0) {
  //       $this->success('Record updated successfully!');
  //     }else{
  //       $this->success('Failed to updated role record. Please try again later.');
  //     }
	// 	}

	// 	// Optionally reset form fields after save
	// 	$this->reset(['role_id', 'role_id']);
  //   $this->reset(['edit_description', 'edit_description']);

	// 	// Close the modal
	// 	$this->editRoleModal  = false;

	// 	$this->roles();
	// }

  // public function openDeleteRoleModal(int $role_id){
	// 	$this->deleteRoleModal = true;
	// 	$this->role_id = $role_id;
	// }

	// public function delete($role_id){
  //   $param = [  $role_id, 0 ];
  //   $sp_query = "EXEC pr_role_by_id_del :role_id, :result_id;";
  //   $result = DB::connection('iclearance_connection')->select($sp_query, $param);
		
	// 	// Toast
  //   if ($result[0]->result_id > 0) {
  //     $this->success('Record deleted successfully!');
  //   }else{
  //     $this->success('Failed to remove role. Please try again later.');
  //   }

	// 	$this->reset('role_id');
	// 	$this->deleteRoleModal = false;	
	// }


	public function render(){
		return view('livewire.pages.clearance-area.clearance-area');
	}

}
