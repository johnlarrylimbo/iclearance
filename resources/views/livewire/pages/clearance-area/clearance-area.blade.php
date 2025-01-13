<div class="py-12">

  <x-mary-header title="Clearance Area" subtitle="Clearance area result list">
    <x-slot:actions>
      <x-mary-input icon="o-bolt" placeholder="Search..." wire:model.live="search"/>
        <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.addClearanceAreaModal = true" />
    </x-slot:actions>
  </x-mary-header>

  <x-mary-card shadow separator>
    
    <div class="my-4">
      {{ $this->clearance_area->links() }}
    </div>

    <table width="100%" class="table mb-4 table-striped" style="table-layout: fixed;">
      <thead>
        <tr class="fs-14 pink h-2rem">
          <th class="align-center wd-5">#</th>
          <th class="align-center w-15">Parent Area</th>
          <th class="align-center w-30">Description</th>
          <th class="align-center wd-5">Sort</th>
          <th class="align-center w-10">Student<br />Area?</th>
          <th class="align-center w-10">Employee<br />Area?</th>
          <th class="align-center w-10">Default<br />Cleared?</th>
          <th class="align-center w-10">Status</th>
          <th class="align-center w-15">Manage</th>
        </tr>
      </thead>
      <tbody>
        @if(count($this->clearance_area) == 0)
          <tr class="fs-13 border-btm content-tr">
            <td class="align-center" colspan="9">No clearance area record(s) found.</td>
          </tr>
				@else
          @foreach ($this->clearance_area as $result)
            <tr class="fs-13 border-btm content-tr">
              <td class="align-center">{{ $result->row_num }}</td>
              <td class="align-left">{{ $result->parent_clearance_area_label }}</td>
              <td class="align-left">{{ $result->label }} - [ {{ $result->abbreviation }} ]</td>
              <td class="align-center">{{ $result->sort }}</td>
              <td class="align-center">{{ $result->is_student_clearance_area }}</td>
              <td class="align-center">{{ $result->is_employee_clearance_area }}</td>
              <td class="align-center">{{ $result->default_cleared }}</td>
              <td class="align-center">
                @if($result->statuscode == 1000)
                  <x-mary-badge value="{{ $result->statuscode_label }}" class="badge-primary" />
                @else
                  <x-mary-badge value="{{ $result->statuscode_label }}" class="badge-warning" />
                @endif
              </td>
              <td class="align-center">
                <x-mary-button icon="o-pencil-square" 
                                wire:click="openEditClearanceAreaModal({{ $result->clearance_area_id }})" 
                                spinner 
                                class="btn-success btn-sm align-center" />&nbsp;
                <x-mary-button icon="o-trash"
                                wire:click="openDeleteClearanceAreaModal({{ $result->clearance_area_id }})"
                                class="btn-error btn-sm align-center"
                                spinner
                                />
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="my-4">
      {{ $this->clearance_area->links() }}
    </div>

  </x-mary-card>    

  <x-mary-modal wire:model="addClearanceAreaModal" class="backdrop-blur">
    <x-mary-form wire:submit.prevent="save" no-separator>

      <x-mary-select
						label="Parent Clearance Area"
						:options="$this->parent_clearance_area_options"
						option-value="clearance_area_id"
						option-label="label"
						placeholder="Select a parent clearance area"
						placeholder-value=""
						hint="Select one, please."
						wire:model="parent_clearance_area_id" />

      <x-mary-input label="Abbreviation" wire:model="abbreviation" id="abbreviation" />

      <x-mary-input label="Description" wire:model="description" id="description" />

      <x-mary-select
						label="Sorting Number"
						:options="$this->sorting_numbers_options"
						option-value="default_id_value"
						option-label="label"
						placeholder="Select a sorting number"
						placeholder-value="0"
						hint="Select one, please."
						wire:model="sort" />
      
      <x-mary-select
						label="Is Student Clearance Area?"
						:options="$this->yes_or_no_options"
						option-value="default_id_value"
						option-label="label"
						placeholder="Select a choices"
						placeholder-value=""
						hint="Select one, please."
						wire:model="is_student_clearance_area" />

      <x-mary-select
						label="Is Employee Clearance Area?"
						:options="$this->yes_or_no_options"
						option-value="default_id_value"
						option-label="label"
						placeholder="Select a choices"
						placeholder-value=""
						hint="Select one, please."
						wire:model="is_employee_clearance_area" />

      <x-mary-select
						label="Is Area Default Cleared?"
						:options="$this->cleared_not_cleared_options"
						option-value="default_id_value"
						option-label="label"
						placeholder="Select a choices"
						placeholder-value=""
						hint="Select one, please."
						wire:model="is_clearance_area_default_cleared" />
   
      <x-slot:actions>
          <x-mary-button label="Cancel" @click="$wire.addClearanceAreaModal = false"/>
          <x-mary-button label="Save Record" class="btn-primary" type="submit" spinner="save" />
      </x-slot:actions>

    </x-mary-form>
  </x-mary-modal>

  <x-mary-modal wire:model="editClearanceAreaModal" class="backdrop-blur">
    <x-mary-form wire:submit.prevent="save_edit" no-separator>

      <x-mary-input type="hidden" wire:model="clearance_area_id" id="clearance_area_id" />
      
      <x-mary-select
						label="Parent Clearance Area"
						:options="$this->parent_clearance_area_options"
						option-value="clearance_area_id"
						option-label="label"
						placeholder="Select a parent clearance area"
						placeholder-value=""
						hint="Select one, please."
						wire:model="edit_parent_clearance_area_id" />

      <x-mary-input label="Abbreviation" wire:model="edit_abbreviation" id="edit_abbreviation" />

      <x-mary-input label="Description" wire:model="edit_description" id="edit_description" />

      <x-mary-select
						label="Sorting Number"
						:options="$this->sorting_numbers_options"
						option-value="default_id_value"
						option-label="label"
						placeholder="Select a sorting number"
						placeholder-value="0"
						hint="Select one, please."
						wire:model="edit_sort" />
      
      <x-mary-select
						label="Is Student Clearance Area?"
						:options="$this->yes_or_no_options"
						option-value="default_id_value"
						option-label="label"
						placeholder="Select a choices"
						placeholder-value=""
						hint="Select one, please."
						wire:model="edit_is_student_clearance_area" />

      <x-mary-select
						label="Is Employee Clearance Area?"
						:options="$this->yes_or_no_options"
						option-value="default_id_value"
						option-label="label"
						placeholder="Select a choices"
						placeholder-value=""
						hint="Select one, please."
						wire:model="edit_is_employee_clearance_area" />

      <x-mary-select
						label="Is Area Default Cleared?"
						:options="$this->cleared_not_cleared_options"
						option-value="default_id_value"
						option-label="label"
						placeholder="Select a choices"
						placeholder-value=""
						hint="Select one, please."
						wire:model="edit_is_clearance_area_default_cleared" />

      <x-slot:actions>
        <x-mary-button label="Cancel" @click="$wire.editClearanceAreaModal = false"/>
        <x-mary-button label="Save Record" class="btn-primary" type="submit" spinner="save_edit" />
      </x-slot:actions>
    </x-mary-form>
  </x-mary-modal>

  <x-mary-modal wire:model="deleteClearanceAreaModal" class="backdrop-blur" title="Delete Confirmation" separator>

    <p>Are you sure want to delete?</p>

    <x-slot:actions>
        <x-mary-button label="Cancel" wire:click="deleteClearanceAreaModal = false" />
        <x-mary-button label="Confirm" class="btn-primary" spinner="delete" wire:click="delete({{ $clearance_area_id }})"  />
    </x-slot:actions>

  </x-mary-modal>

  
</div>



    








