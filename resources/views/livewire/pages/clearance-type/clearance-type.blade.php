<div class="py-12">

  <x-mary-header title="Clearance Type" subtitle="Clearance type result list">
    <x-slot:actions>
      <x-mary-input icon="o-bolt" placeholder="Search..." />
        <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.addClearanceTypeModal = true" />
    </x-slot:actions>
  </x-mary-header>

  <x-mary-card shadow separator>
    
    <div class="my-4">
      {{ $this->clearance_type->links() }}
    </div>

    <table width="100%" class="table mb-4 table-striped" style="table-layout: fixed;">
      <thead>
        <tr class="fs-14 pink h-2rem">
          <th class="align-center wd-5">#</th>
          <th class="align-center w-20">Abbreviation</th>
          <th class="align-center w-30">Description</th>
          <th class="align-center w-10">Status</th>
          <th class="align-center w-15">Manage</th>
        </tr>
      </thead>
      <tbody>
        @if(count($this->clearance_type) == 0)
          <tr class="fs-13 border-btm content-tr">
            <td class="align-center" colspan="5">No clearance area record(s) found.</td>
          </tr>
				@else
          @foreach ($this->clearance_type as $result)
            <tr class="fs-13 border-btm content-tr">
              <td class="align-center">{{ $result->row_num }}</td>
              <td class="align-left">{{ $result->abbreviation }}</td>
              <td class="align-left">{{ $result->label }}</td>
              <td class="align-center">
                @if($result->statuscode == 1000)
                  <x-mary-badge value="{{ $result->statuscode_label }}" class="badge-primary" />
                @else
                  <x-mary-badge value="{{ $result->statuscode_label }}" class="badge-warning" />
                @endif
              </td>
              <td class="align-center">
                <x-mary-button icon="o-pencil-square" 
                                wire:click="openEditClearanceTypeModal({{ $result->clearance_type_id }})" 
                                spinner 
                                class="btn-success btn-sm align-center" />&nbsp;
                <x-mary-button icon="o-trash"
                                wire:click="openDeleteClearanceTypeModal({{ $result->clearance_type_id }})"
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
      {{ $this->clearance_type->links() }}
    </div>

  </x-mary-card>    

  <x-mary-modal wire:model="addClearanceTypeModal" class="backdrop-blur">
    <x-mary-form wire:submit.prevent="save" no-separator>

      <x-mary-input label="Abbreviation" wire:model="abbreviation" id="abbreviation" />

      <x-mary-input label="Description" wire:model="description" id="description" />
   
      <x-slot:actions>
          <x-mary-button label="Cancel" @click="$wire.addClearanceTypeModal = false"/>
          <x-mary-button label="Save Record" class="btn-primary" type="submit" spinner="save" />
      </x-slot:actions>

    </x-mary-form>
  </x-mary-modal>

  <x-mary-modal wire:model="editClearanceTypeModal" class="backdrop-blur">
    <x-mary-form wire:submit.prevent="save_edit" no-separator>

      <x-mary-input type="hidden" wire:model="clearance_type_id" id="clearance_type_id" />

      <x-mary-input label="Abbreviation" wire:model="edit_abbreviation" id="edit_abbreviation" />

      <x-mary-input label="Description" wire:model="edit_description" id="edit_description" />

      <x-slot:actions>
        <x-mary-button label="Cancel" @click="$wire.editClearanceTypeModal = false"/>
        <x-mary-button label="Save Record" class="btn-primary" type="submit" spinner="save_edit" />
      </x-slot:actions>
    </x-mary-form>
  </x-mary-modal>

  <x-mary-modal wire:model="deleteClearanceTypeModal" class="backdrop-blur" title="Delete Confirmation" separator>

    <p>Are you sure want to delete?</p>

    <x-slot:actions>
        <x-mary-button label="Cancel" wire:click="deleteClearanceTypeModal = false" />
        <x-mary-button label="Confirm" class="btn-primary" spinner="delete" wire:click="delete({{ $clearance_type_id }})"  />
    </x-slot:actions>

  </x-mary-modal>

  
</div>



    








