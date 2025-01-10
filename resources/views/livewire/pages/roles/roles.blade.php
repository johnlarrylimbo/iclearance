<div class="py-12">

  <x-mary-header title="Roles" subtitle="Roles result list">
    <x-slot:actions>
      <x-mary-input icon="o-bolt" placeholder="Search..." />
        <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.addRoleModal = true" />
    </x-slot:actions>
  </x-mary-header>

  <x-mary-card shadow separator>
    
    <div class="my-4">
      {{ $this->roles->links() }}
    </div>

    <table width="100%" class="table mb-4 table-striped" style="table-layout: fixed;">
      <thead>
        <tr class="fs-14 pink h-2rem">
          <th class="align-center wd-5">#</th>
          <th class="align-center w-25">Role Description</th>
          <th class="align-center w-13">Status</th>
          <th class="align-center w-15">Manage</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($this->roles as $result)
          <tr class="fs-13 border-btm content-tr">
            <td class="align-center">{{ $result->row_num }}</td>
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
                              wire:click="openEditRoleModal({{ $result->role_id }})" 
                              spinner 
                              class="btn-success btn-sm align-center" />&nbsp;
              <x-mary-button icon="o-trash"
                              wire:click="openDeleteRoleModal({{ $result->role_id }})"
                              class="btn-error btn-sm align-center"
                              spinner
                              />
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="my-4">
      {{ $this->roles->links() }}
    </div>

  </x-mary-card>    

  <x-mary-modal wire:model="addRoleModal" class="backdrop-blur">
    <x-mary-form wire:submit.prevent="save" no-separator>

      <x-mary-input label="Role Description" wire:model="description" id="description" />
   
      <x-slot:actions>
          <x-mary-button label="Cancel" @click="$wire.addRoleModal = false"/>
          <x-mary-button label="Save Record" class="btn-primary" type="submit" spinner="save" />
      </x-slot:actions>

    </x-mary-form>
  </x-mary-modal>

  {{-- <x-mary-modal wire:model="editHealthClaimCategoryModal" class="backdrop-blur">
    <x-mary-form wire:submit.prevent="save_edit" no-separator>
      <x-mary-input type="hidden" wire:model="health_claim_category_id" id="health_claim_category_id" />
      
      <x-mary-input label="Company Name" wire:model="edit_description" id="edit_description" />

      <x-slot:actions>
        <x-mary-button label="Cancel" @click="$wire.editHealthClaimCategoryModal = false"/>
        <x-mary-button label="Save Record" class="btn-primary" type="submit" spinner="save_edit" />
      </x-slot:actions>
    </x-mary-form>
  </x-mary-modal>

  <x-mary-modal wire:model="deleteHealthClaimCategoryModal" class="backdrop-blur" title="Delete Confirmation" separator>

    <p>Are you sure want to delete?</p>

    <x-slot:actions>
        <x-mary-button label="Cancel" wire:click="deleteHealthClaimCategoryModal = false" />
        <x-mary-button label="Confirm" class="btn-primary" spinner="delete" wire:click="delete({{ $health_claim_category_id }})"  />
    </x-slot:actions>

  </x-mary-modal> --}}

  
</div>



    








