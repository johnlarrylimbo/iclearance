<div class="py-12">

  <x-mary-header title="Access Permission Request" subtitle="Access permission request list">
    <x-slot:actions>
      <x-mary-input icon="o-bolt" placeholder="Search..." />
        <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.addAccessPermissionRequestModal = true" />
    </x-slot:actions>
  </x-mary-header>

  <x-mary-card shadow separator>
    
    <div class="my-4">
      {{ $this->access_permission_request->links() }}
    </div>

    <table width="100%" class="table mb-4 table-striped" style="table-layout: fixed;">
      <thead>
        <tr class="fs-14 pink h-2rem">
          <th class="align-center wd-5">#</th>
          <th class="align-center w-13">Request Code</th>
          <th class="align-center w-25">Description</th>
          <th class="align-center w-13">Date Requested</th>
          <th class="align-center w-13">Date Granted</th>
          <th class="align-center w-20">Status</th>
          <th class="align-center w-15">Manage</th>
        </tr>
      </thead>
      <tbody>
        @if(count($this->access_permission_request) == 0)
          <tr class="fs-13 border-btm content-tr">
            <td class="align-center" colspan="9">No clearance area record(s) found.</td>
          </tr>
				@else
          @foreach ($this->access_permission_request as $result)
            <tr class="fs-13 border-btm content-tr">
              <td class="align-center vertical-align-top">{{ $result->row_num }}</td>
              <td class="align-center vertical-align-top">{{ $result->request_code }}</td>
              <td class="align-left vertical-align-top">{{ $result->clearance_area_label }}</td>
              <td class="align-center vertical-align-top">{{ $result->requested_at }}</td>
              <td class="align-center vertical-align-top">
                {{ $result->granted_at }}<br /><br />
                {{ $result->granter_name }}
              </td>
              <td class="align-center vertical-align-top">
                @if($result->statuscode == 1000)
                  <x-mary-badge value="{{ $result->statuscode_label }}" class="badge-primary" />
                @elseif($result->statuscode == 1003)
                    <x-mary-badge value="{{ $result->statuscode_label }}" class="badge-warning" />
                @else
                  <x-mary-badge value="{{ $result->statuscode_label }}" class="badge-warning" />
                @endif
              </td>
              <td class="align-center vertical-align-top">
                @if($result->statuscode == 1003)
                  Not Available
                @else
                  <x-mary-button icon="o-pencil-square" 
                                  wire:click="openEditAccessPermissionRequestModal({{ $result->access_permission_request_id }})" 
                                  spinner 
                                  class="btn-success btn-sm align-center" />&nbsp;
                  <x-mary-button icon="o-trash"
                                  wire:click="openDeleteAccessPermissionRequestModal({{ $result->access_permission_request_id }})"
                                  class="btn-error btn-sm align-center"
                                  spinner
                                  />
                @endif
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="my-4">
      {{ $this->access_permission_request->links() }}
    </div>

  </x-mary-card>    

  <x-mary-modal wire:model="addAccessPermissionRequestModal" class="backdrop-blur">
    <x-mary-form wire:submit.prevent="save" no-separator>

      <x-mary-select
						label="Clearance Area to Request Access"
						:options="$this->clearance_area_item_options"
						option-value="id"
						option-label="name"
						placeholder="Select a clearance area to request access"
						placeholder-value="0"
						hint="Select one, please."
						wire:model="clearance_area_id" />
   
      <x-slot:actions>
          <x-mary-button label="Cancel" @click="$wire.addAccessPermissionRequestModal = false"/>
          <x-mary-button label="Save Record" class="btn-primary" type="submit" spinner="save" />
      </x-slot:actions>

    </x-mary-form>
  </x-mary-modal>

  <x-mary-modal wire:model="editAccessPermissionRequestModal" class="backdrop-blur">
    <x-mary-form wire:submit.prevent="save_edit" no-separator>

      <x-mary-input type="hidden" wire:model="access_permission_request_id" id="access_permission_request_id" />
      
      <x-mary-select
						label="Clearance Area to Request Access"
						:options="$this->clearance_area_item_options"
						option-value="id"
						option-label="name"
						placeholder="Select a clearance area to request access"
						placeholder-value="0"
						hint="Select one, please."
						wire:model="edit_clearance_area_id" />

      <x-slot:actions>
        <x-mary-button label="Cancel" @click="$wire.editAccessPermissionRequestModal = false"/>
        <x-mary-button label="Save Record" class="btn-primary" type="submit" spinner="save_edit" />
      </x-slot:actions>
    </x-mary-form>
  </x-mary-modal>

  <x-mary-modal wire:model="deleteAccessPermissionRequestModal" class="backdrop-blur" title="Delete Confirmation" separator>

    <p>Are you sure want to delete?</p>

    <x-slot:actions>
        <x-mary-button label="Cancel" wire:click="deleteAccessPermissionRequestModal = false" />
        <x-mary-button label="Confirm" class="btn-primary" spinner="delete" wire:click="delete({{ $access_permission_request_id }})"  />
    </x-slot:actions>

  </x-mary-modal>

  
</div>



    








