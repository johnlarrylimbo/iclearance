<div class="py-12">

  <x-mary-header title="Access Permission Request" subtitle="Access permission request list">
    <x-slot:actions>
      <x-mary-input icon="o-bolt" placeholder="Search..." wire:model.live="search"/>
        <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.addAccessPermissionRequestModal = true" />
    </x-slot:actions>
  </x-mary-header>

  <x-mary-card shadow separator>
    
    <div class="my-4">
      {{ $this->permission_request->links() }}
    </div>

    <table width="100%" class="table mb-4 table-striped" style="table-layout: fixed;">
      <thead>
        <tr class="fs-14 pink h-2rem">
          <th class="align-center wd-5">#</th>
          <th class="align-center w-13">Request Code</th>
          <th class="align-center w-25">Description</th>
          <th class="align-center w-13">Date Requested</th>
          <th class="align-center w-20">Requested By</th>
          <th class="align-center w-20">Status</th>
          <th class="align-center w-15">Manage</th>
        </tr>
      </thead>
      <tbody>
        @if(count($this->permission_request) == 0)
          <tr class="fs-13 border-btm content-tr">
            <td class="align-center" colspan="9">No clearance permission request record(s) found.</td>
          </tr>
				@else
          @foreach ($this->permission_request as $result)
            <tr class="fs-13 border-btm content-tr">
              <td class="align-center vertical-align-top">{{ $result->row_num }}</td>
              <td class="align-center vertical-align-top">{{ $result->request_code }}</td>
              <td class="align-left vertical-align-top">{{ $result->clearance_area_label }}</td>
              <td class="align-center vertical-align-top">{{ $result->requested_at }}</td>
              <td class="align-left vertical-align-top">{{ $result->requested_by_name }}</td>
              <td class="align-center vertical-align-top">
                @if($result->statuscode == 1000)
                  <x-mary-badge value="{{ $result->statuscode_label }}" class="badge-primary" />
                @endif
              </td>
              <td class="align-center vertical-align-top">
                <x-mary-button icon="c-hand-thumb-up" 
                                wire:click="openEditAccessPermissionRequestApprovedModal({{ $result->access_permission_request_id }})"
                                title="Approve access permission request." 
                                spinner 
                                class="btn-success btn-sm align-center" />&nbsp;
                <x-mary-button icon="c-hand-thumb-down"
                                wire:click="openDeleteAccessPermissionRequestDisapprovedModal({{ $result->access_permission_request_id }})"
                                class="btn-error btn-sm align-center"
                                title="Disapprove access permission request."
                                spinner
                                />
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="my-4">
      {{ $this->permission_request->links() }}
    </div>

  </x-mary-card>    


  <x-mary-modal wire:model="approveAccessPermissionRequestModal" class="backdrop-blur" title="Approval Confirmation" separator>

    <p>Are you sure want to approved this clearance access permission request?</p>

    <x-slot:actions>
        <x-mary-button label="Cancel" wire:click="approveAccessPermissionRequestModal = false" />
        <x-mary-button label="Confirm" class="btn-primary" spinner="delete" wire:click="approve_access_permission_request({{ $access_permission_request_id }})"  />
    </x-slot:actions>

  </x-mary-modal>

  <x-mary-modal wire:model="disapproveAccessPermissionRequestModal" class="backdrop-blur" title="Disapproval Confirmation" separator>

    <p>Are you sure want to disapprove this clearance access permission request?</p>

    <x-slot:actions>
        <x-mary-button label="Cancel" wire:click="disapproveAccessPermissionRequestModal = false" />
        <x-mary-button label="Confirm" class="btn-primary" spinner="delete" wire:click="disapprove_access_permission_request({{ $access_permission_request_id }})"  />
    </x-slot:actions>

  </x-mary-modal>

  
</div>



    








