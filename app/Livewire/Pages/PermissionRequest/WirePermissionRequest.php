<?php

namespace App\Livewire\Pages\PermissionRequest;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;

use Illuminate\Support\Facades\DB;

use App\Services\PermissionRequestService;
use App\Services\SelectOptionLibraryService;

use Livewire\WithPagination;
use Mary\Traits\Toast;

use session;

#[Lazy]
#[Layout('layouts.app')]
class WirePermissionRequest extends Component
{

	use WithPagination;
	use Toast;

	protected $permission_request_service;
	protected $select_option_library_service;

	public bool $approveAccessPermissionRequestModal = false;
	public bool $disapproveAccessPermissionRequestModal = false;

	public $access_permission_request_id;
	public $clearance_area_id;
	public $access_permission_department_id;
	public $granter_id;
  public $edit_clearance_area_id;	

	public $search;	

	public function boot(
		PermissionRequestService $permission_request_service,
		SelectOptionLibraryService $select_option_library_service,
	)
	{
		$this->permission_request_service = $permission_request_service;
		$this->select_option_library_service = $select_option_library_service;
	}

	// Load records from the database
	#[Computed]
	// public function loadRecords
	public function permission_request(){
		if(!$this->search){
			$permission_request = $this->permission_request_service->loadPermissionRequest()->paginate(10);
			return $permission_request;
		}
		else{
			$permission_request = $this->permission_request_service->searchPermissionRequestByKeyword($this->search)->paginate(10);
			return $permission_request;
		}
	}

	#[Computed]
	// public function loadHealthClaimCategoryOptions()
	public function clearance_access_permission_department_options(){
		return $this->select_option_library_service->loadClearanceAccessPermissionDepartmentOptions();
	}

	public function mount(){
		// Initialize form fields
		$this->access_permission_department_id = 0;
		$this->granter_id = 0;
	}

  public function openEditAccessPermissionRequestApprovedModal(int $access_permission_request_id){
		$this->approveAccessPermissionRequestModal = true;
		$this->access_permission_request_id = $access_permission_request_id;
	}

  public function approve_access_permission_request($access_permission_request_id){

		// Validation and saving logic
		$this->validate([
      'access_permission_department_id' => 'required|not_in:0'
		]);

    $param = [  $access_permission_request_id, $this->access_permission_department_id, auth()->user()->user_account_id, 0 ];
    $sp_query = "EXEC pr_access_permission_request_approve_by_id :access_permission_request_id, :access_permission_department_id, :user_account_id, :result_id;";
    $result = DB::connection('iclearance_connection')->select($sp_query, $param);
		
		// Toast
    $this->success('Access permission request approved successfully!');

		$this->reset('access_permission_request_id');
		$this->approveAccessPermissionRequestModal = false;	
	}

  public function openDeleteAccessPermissionRequestDisapprovedModal(int $access_permission_request_id){
		$this->disapproveAccessPermissionRequestModal = true;
		$this->access_permission_request_id = $access_permission_request_id;
	}

  public function disapprove_access_permission_request($access_permission_request_id){
    $param = [  $access_permission_request_id, 0 ];
    $sp_query = "EXEC pr_access_permission_request_disapprove_by_id :access_permission_request_id, :result_id;";
    $result = DB::connection('iclearance_connection')->select($sp_query, $param);
		
		// Toast
    $this->success('Access permission request successfully disapproved!');

		$this->reset('access_permission_request_id');
		$this->disapproveAccessPermissionRequestModal = false;	
	}

	public function render(){
		return view('livewire.pages.permission-request.permission-request');
	}

}
