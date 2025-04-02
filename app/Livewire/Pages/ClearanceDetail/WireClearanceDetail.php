<?php

namespace App\Livewire\Pages\ClearanceDetail;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

use Illuminate\Support\Facades\DB;

// use App\Services\ClearanceDetailService;

use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Lazy]
#[Layout('layouts.app')]
class WireClearanceDetail extends Component
{
  use Toast;
  use WithPagination;

	#[Url(as: 'clearance_id')]
	public $clearance_id = '';

	// protected $clearance_detail_service;


	// public $search;

	// public function boot(
	// 	ClearanceDetailService $clearance_detail_service,
	// )
	// {
	// 	$this->clearance_detail_service = $clearance_detail_service;
	// }


	public function mount(){
		// Initialize form fields
	}


	public function render()
	{
			return view('livewire.pages.clearance-management.clearance-management');
	}
}
