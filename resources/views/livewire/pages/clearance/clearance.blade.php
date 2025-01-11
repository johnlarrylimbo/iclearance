<div class="py-12">

  <x-mary-header title="Clearance Management" subtitle="Clearance record result list">
    <x-slot:actions>
      <x-mary-input icon="o-bolt" placeholder="Search..." />
        <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.addClearancePeriodTypeModal = true" />
    </x-slot:actions>
  </x-mary-header>

  <x-mary-card shadow separator>
    
    <div class="my-4">
      {{ $this->clearance->links() }}
    </div>

    <table width="100%" class="table mb-4 table-striped" style="table-layout: fixed;">
      <thead>
        <tr class="fs-14 pink h-2rem">
          <th class="align-center wd-5">#</th>
          <th class="align-center w-13">Clearance Type</th>
          <th class="align-center w-30">Description</th>
          <th class="align-center w-15">Period</th>
          <th class="align-center w-15">Status</th>
          <th class="align-center w-30">Manage</th>
        </tr>
      </thead>
      <tbody>
        @if(count($this->clearance) == 0)
          <tr class="fs-13 border-btm content-tr">
            <td class="align-center" colspan="7">No clearance record(s) found.</td>
          </tr>
				@else
          @foreach ($this->clearance as $result)
            <tr class="fs-13 border-btm content-tr">
              <td class="align-center vertical-align-top">{{ $result->row_num }}</td>
              <td class="align-left vertical-align-top"">{{ $result->clearance_type_label }}</td>
              <td class="align-left vertical-align-top"">
                {{ $result->description }}<br />
                {{ $result->clearance_code }}<br /><br />
                @if($result->is_populated == 'Populated')
                  <x-mary-badge value="{{ $result->is_populated }}" class="badge-primary" />
                @else
                  <x-mary-badge value="{{ $result->is_populated }}" class="badge-warning" />
                @endif
              </td>
              <td class="align-center vertical-align-top"">
                {{ $result->period_description }}<br /><br />
                @if($result->is_open == 'Open')
                  <x-mary-badge value="{{ $result->is_open }}" class="badge-primary" />
                @else
                  <x-mary-badge value="{{ $result->is_open }}" class="badge-warning" />
                @endif
              </td>
              <td class="align-center vertical-align-top"">
                @if($result->statuscode == 1000)
                  <x-mary-badge value="{{ $result->statuscode_label }}" class="badge-primary" />
                @else
                  <x-mary-badge value="{{ $result->statuscode_label }}" class="badge-warning" />
                @endif
              </td>
              <td class="align-center vertical-align-top"">
                @if($result->is_populated == 'Populated')
                @else
                  <x-mary-button icon="o-pencil-square" 
                                  wire:click="openEditClearanceModal({{ $result->clearance_id }})" 
                                  title="Edit clearance information."
                                  spinner 
                                  class="btn-success btn-sm align-center" />&nbsp;
                  <x-mary-button icon="m-numbered-list" 
                                  wire:click="openAddClearanceAreaItemModal({{ $result->clearance_id }})" 
                                  title="Add clearance area item(s) information."
                                  spinner 
                                  class="btn-success btn-sm align-center" />&nbsp;
                  <x-mary-button icon="m-users" 
                                  wire:click="openAddClearanceEmployeeModal({{ $result->clearance_id }})" 
                                  title="Enroll employee to clearance record."
                                  spinner 
                                  class="btn-success btn-sm align-center" />&nbsp;
                  <x-mary-button icon="o-inbox-arrow-down" 
                                  wire:click="openEditClearanceModal({{ $result->clearance_id }})" 
                                  title="Populate employee clearance(s)."
                                  spinner 
                                  class="btn-primary btn-sm align-center" />&nbsp;
                @endif
                <x-mary-button icon="o-trash"
                                wire:click="openDeleteClearanceModal({{ $result->clearance_id }})"
                                class="btn-error btn-sm align-center"
                                title="Remove clearance record."
                                spinner
                                />
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="my-4">
      {{ $this->clearance->links() }}
    </div>

  </x-mary-card>    

  <x-mary-modal wire:model="addSemesterClearanceModal" class="backdrop-blur">
    <x-mary-form wire:submit.prevent="save_semestral_clearance" no-separator>

      <x-mary-input type="hidden" wire:model="period_type_id" id="period_type_id" />

      <x-mary-select
						label="Period Semester"
						:options="$this->period_semester_options"
						option-value="period_semester_id"
						option-label="period_description"
						placeholder="Select a period semester"
						placeholder-value="0"
						hint="Select one, please."
						wire:model="period_id" />

      <x-mary-select
						label="Clearance Type"
						:options="$this->clearance_type_options"
						option-value="clearance_type_id"
						option-label="label"
						placeholder="Select a clearance type"
						placeholder-value="0"
						hint="Select one, please."
						wire:model="clearance_type_id" />

      <x-mary-input label="Description / Name" wire:model="description" id="description" />

      <x-mary-select
						label="Default Status"
						:options="$this->select_option_library_options"
						option-value="default_id_value"
						option-label="label"
						placeholder="Select a default status"
						placeholder-value="0"
						hint="Select one, please."
						wire:model="is_open" />
   
      <x-slot:actions>
          <x-mary-button label="Cancel" @click="$wire.addSemesterClearanceModal = false"/>
          <x-mary-button label="Save Record" class="btn-primary" type="submit" spinner="save_semestral_clearance" />
      </x-slot:actions>

    </x-mary-form>
  </x-mary-modal>

  <x-mary-modal wire:model="addAnnualClearanceModal" class="backdrop-blur">
    <x-mary-form wire:submit.prevent="save_annual_clearance" no-separator>

      <x-mary-input type="hidden" wire:model="period_type_id" id="period_type_id" />

      <x-mary-select
						label="Period Semester"
						:options="$this->period_academic_year_options"
						option-value="period_academic_year_id"
						option-label="period_description"
						placeholder="Select a period academic year"
						placeholder-value="0"
						hint="Select one, please."
						wire:model="period_id" />

      <x-mary-select
						label="Clearance Type"
						:options="$this->clearance_type_options"
						option-value="clearance_type_id"
						option-label="label"
						placeholder="Select a clearance type"
						placeholder-value="0"
						hint="Select one, please."
						wire:model="clearance_type_id" />

      <x-mary-input label="Description / Name" wire:model="description" id="description" />

      <x-mary-select
						label="Default Status"
						:options="$this->select_option_library_options"
						option-value="default_id_value"
						option-label="label"
						placeholder="Select a default status"
						placeholder-value="0"
						hint="Select one, please."
						wire:model="is_open" />
   
      <x-slot:actions>
          <x-mary-button label="Cancel" @click="$wire.addAnnualClearanceModal = false"/>
          <x-mary-button label="Save Record" class="btn-primary" type="submit" spinner="save_annual_clearance" />
      </x-slot:actions>

    </x-mary-form>
  </x-mary-modal>

  <x-mary-modal wire:model="addClearanceAreaRecordModal" class="backdrop-blur">
		<x-mary-form wire:submit.prevent="save_clearance_area_record" no-separator>

      <x-mary-input type="hidden" wire:model="clearance_id" id="clearance_id" />

			<x-mary-choices label="Clearance Area Item(s)" wire:model="clearance_area_item_id"
					:options="$this->clearance_area_item_select_options"
					allow-all/>
      <br /><br /><br /><br /><br /><br />
			<x-slot:actions>
				<x-mary-button label="Cancel" @click="$wire.addClearanceAreaRecordModal = false"/>
				<x-mary-button label="Save Record" class="btn-primary" type="submit" spinner="save_clearance_area_record" />
			</x-slot:actions>
		</x-form>
	</x-mary-modal>

  <x-mary-modal wire:model="addClearanceEmployeeRecordModal" class="backdrop-blur">
		<x-mary-form wire:submit.prevent="save_clearance_employee_record" no-separator>

      <x-mary-input type="hidden" wire:model="clearance_id" id="clearance_id" />

			<x-mary-choices label="Clearance Employee Item(s)" wire:model="clearance_employee_id"
					:options="$this->clearance_employee_select_options"/>

      <br /><br /><br /><br /><br /><br />
      
			<x-slot:actions>
				<x-mary-button label="Cancel" @click="$wire.addClearanceEmployeeRecordModal = false"/>
				<x-mary-button label="Save Record" class="btn-primary" type="submit" spinner="save_clearance_employee_record" />
			</x-slot:actions>
		</x-form>
	</x-mary-modal>

  <x-mary-modal wire:model="editClearanceModal" class="backdrop-blur">
    <x-mary-form wire:submit.prevent="save_edit" no-separator>

      <x-mary-input type="hidden" wire:model="clearance_id" id="clearance_id" />

      <x-mary-input label="Description" wire:model="edit_description" id="edit_description" />

      <x-mary-select
						label="Default Status"
						:options="$this->select_option_library_options"
						option-value="default_id_value"
						option-label="label"
						placeholder="Select a default status"
						placeholder-value="0"
						hint="Select one, please."
						wire:model="edit_is_open" />

      <x-slot:actions>
        <x-mary-button label="Cancel" @click="$wire.editClearanceModal = false"/>
        <x-mary-button label="Save Record" class="btn-primary" type="submit" spinner="save_edit" />
      </x-slot:actions>
    </x-mary-form>
  </x-mary-modal>

  <x-mary-modal wire:model="deleteClearanceModal" class="backdrop-blur" title="Delete Confirmation" separator>

    <p>Are you sure want to delete?</p>

    <x-slot:actions>
        <x-mary-button label="Cancel" wire:click="deleteClearanceModal = false" />
        <x-mary-button label="Confirm" class="btn-primary" spinner="delete" wire:click="delete({{ $clearance_id }})"  />
    </x-slot:actions>

  </x-mary-modal>

  <x-mary-modal wire:model="addClearancePeriodTypeModal" class="backdrop-blur">
    <x-mary-form wire:submit.prevent="save_period_type" no-separator>

      <x-mary-select
						label="Clearance Period Type"
						:options="$this->period_type_options"
						option-value="period_type_id"
						option-label="label"
						placeholder="Select a period type"
						placeholder-value="0"
						hint="Select one, please."
						wire:model="period_type_id" />
   
      <x-slot:actions>
          <x-mary-button label="Cancel" @click="$wire.addClearancePeriodTypeModal = false"/>
          <x-mary-button label="Proceed" class="btn-primary" type="submit" spinner="save_period_type" />
      </x-slot:actions>

    </x-mary-form>
  </x-mary-modal>

  
</div>



    








