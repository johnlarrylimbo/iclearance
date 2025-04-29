<div>
  
  <x-mary-header title="Clearance Management" subtitle="Clearance management dashboard." >
    <x-slot:actions>
      <x-mary-input icon="o-bolt" placeholder="Search Clearance..." wire:model.live="search"/>
    </x-slot:actions>
  </x-mary-header>

  <x-mary-card shadow separator>

    <div class="my-4">
			{{ $this->my_clearance_lst->links() }}
		</div>

    <table width="100%" class="table mb-4 table-striped" style="table-layout: fixed;">
      <thead>
        <tr class="fs-14 pink h-2rem">
          <th class="align-center wd-5">#</th>
          <th class="align-center w-5">Code</th>
          <th class="align-center w-15">Clearance Type</th>
          <th class="align-center w-30">Description</th>
          <th class="align-center w-5">Is<br />Open?</th>
          <th class="align-center w-10">Status</th>
          <th class="align-center w-15">Manage</th>
        </tr>
      </thead>
      <tbody>
        @if(count($this->my_clearance_lst) == 0)
          <tr class="fs-13 border-btm content-tr">
            <td class="align-center" colspan="7">No clearance record(s) found.</td>
          </tr>
				@else
          @foreach ($this->my_clearance_lst as $result)
            <tr class="fs-13 border-btm content-tr">
              <td class="align-center vertical-align-top">{{ $result->row_num }}</td>
              <td class="align-left vertical-align-top">{{ $result->clearance_code }}</td>
              <td class="align-left vertical-align-top">{{ $result->clearance_type_label }}</td>
              <td class="align-left vertical-align-top">{{ $result->description }}</td>
              <td class="align-center vertical-align-top">
                @if($result->is_open == 'Open')
                  <x-mary-badge value="{{ $result->is_open_label }}" class="badge-primary" />
                @else
                  <x-mary-badge value="{{ $result->is_open_label }}" class="badge-warning" />
                @endif
              </td>
              <td class="align-center vertical-align-top">
                @if($result->statuscode == 1000)
                  <x-mary-badge value="{{ $result->clearance_detail_status_label }}" class="badge-primary" />
                @else
                  <x-mary-badge value="{{ $result->clearance_detail_status_label }}" class="badge-warning" />
                @endif
              </td>
              <td class="align-center vertical-align-top">
                {{-- <a href="/clearance-detail/{{ $result->clearance_id }}" class="btn-success btn-sm align-center">{{ svg('heroicon-s-users') }}</a> --}}
                <x-mary-button icon="o-bars-3-bottom-left" 
                                wire:click="openClearanceDetailWindow({{ $result->clearance_detail_id }})" 
                                spinner 
                                class="btn-success btn-sm align-center" />&nbsp;
                {{-- <x-mary-button icon="s-user-plus"
                                wire:click="openClearanceEmployeeEnrollmentWindow({{ $result->clearance_detail_id }})"
                                class="btn-error btn-sm align-center"
                                spinner
                                /> --}}
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="my-4">
			{{ $this->my_clearance_lst->links() }}
		</div>

  </x-mary-card>


</div>