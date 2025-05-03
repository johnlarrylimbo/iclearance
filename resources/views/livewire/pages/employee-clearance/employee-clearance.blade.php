<div>
  
  @foreach ($this->employee_clearance_detail as $employee_clearance_detail)
    @if(count($this->employee_clearance_detail) == 0)
      <x-mary-header title="Employee Clearance" subtitle="Employee clearance management dashboard." class="fs-27">
        <x-slot:actions>
          <x-mary-input icon="o-bolt" placeholder="Search Employee..." wire:model.live="search"/>
        </x-slot:actions>
      </x-mary-header>
    @else
      <x-mary-header title="{{ $employee_clearance_detail->clearance_description }}" subtitle="{{ $employee_clearance_detail->clearance_description }} management dashboard." class="fs-27">
        <x-slot:actions>
          <x-mary-input icon="o-bolt" placeholder="Search Employee..." wire:model.live="search"/>
        </x-slot:actions>
      </x-mary-header>
    @endif
  @endforeach

  <x-mary-card shadow separator>

    <div class="my-4">
			{{ $this->employee_clearance_lst->links() }}
		</div>

    <table width="100%" class="table mb-4 table-striped" style="table-layout: fixed;">
      <thead>
        <tr class="fs-14 pink" style="height: 88px !important;">
          <th class="align-center wd-5">#</th>
          <th class="align-center w-30">Employee Name</th>
          <th class="align-center wd-10">Gender</th>
          <th class="align-center wd-10">Email</th>
          <th class="align-center wd-10">Department</th>
          <th class="align-center wd-10">Manage</th>
          {{-- @if(count($this->clearance_area_lst) == 0)
            <th class="align-center" colspan="5">No available assigned clearance area</th>
          @else
            @foreach ($this->clearance_area_lst as $clearance_area_lst)
              <th class="align-center wd-10 word-wrap vertical-align-top">{{ $clearance_area_lst->clearance_area_abbreviation }}</th>
            @endforeach
          @endif --}}
        </tr>
      </thead>
      <tbody>
        @if(count($this->employee_clearance_lst) == 0)
          <tr class="fs-13 border-btm content-tr">
            @if(count($this->clearance_area_lst) == 0)
              <td class="align-center" colspan="6">No clearance record(s) found.</td>
            @else
              <td class="align-center" colspan="6">No clearance record(s) found.</td>
            @endif
          </tr>
				@else
          @foreach ($this->employee_clearance_lst as $result)
            <tr class="fs-13 border-btm content-tr">
              <td class="align-center vertical-align-top">{{ $result->row_num }}</td>
              <td class="align-left vertical-align-top">{{ $result->employee_name }} 
                {{-- <button wire:click="toggleRow({{ $result->clearance_detail_id }})"
                class="text-blue-500 underline">
                Toggle
                </button> --}}
              </td>
              <td class="align-center vertical-align-top">{{ $result->gender }}</td>
              <td class="align-center vertical-align-top">{{ $result->email_address }}</td>
              <td class="align-center vertical-align-top">{{ $result->department_code }}</td>
              <td class="align-center vertical-align-top">
                <x-mary-button icon="o-bars-arrow-down" 
                                wire:click="toggleRow({{ $result->clearance_detail_id }})" 
                                {{-- spinner  --}}
                                class="btn-success btn-sm align-center"
                                wire:loading.attr="disabled" />
              </td>

              
            </tr>
            
            @if ($expandedRowId == $result->clearance_detail_id)
                <tr class="collapse-row {{ $expandedRowId == $result->clearance_detail_id ? 'expanded' : '' }}">
                    <tr>
                      <td colspan="6" style="background-color: #ffffff;">
                        <table style="width: 97%; margin: 0px auto; border: 3px solid gray; color: #000000;">
                          <thead>
                            <tr>
                              <td colspan="6" class="p-4 border bg-gray-100" style="background-color: #E82561; color: #ffffff;">
                                <strong>CLEARANCE DETAILS: </strong>
                              </td>
                            </tr>
                            <tr style="background-color: #F2AE66">
                              <th style="font-size: 13px;" class="align-center">#</th>
                              <th style="font-size: 13px;" class="align-center">Clearance Area Description</th>
                              <th style="font-size: 13px;" class="align-center">Status</th>
                              <th style="font-size: 13px;" class="align-center">Cleared By</th>
                              <th style="font-size: 13px;" class="align-center">Date/Time Cleared</th>
                              <th style="font-size: 13px;" class="align-center">Pre-requisite Area</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($this->clearance_area_by_clearance_detail_id_lst as $clearance_area_detail)
                              @if($result->clearance_detail_id == $clearance_area_detail->clearance_detail_id)
                                <tr>
                                  <td style="padding: 8px;" class="align-center">
                                    @if($clearance_area_detail->clearance_type_id == 4) 
                                    {{-- ssp clearance --}}
                                      {{-- @if($employee_active_clearance_detail_lst->is_ssp == 0) 
                                        <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                          :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                          :disabled="$employee_active_clearance_detail_lst->is_ssp == 0"
                                          label-class="custom-label-class"/>
                                      @else --}}
                                        @if($clearance_area_detail->requisite_cleared_remarks == 'not_requisite') 
                                          <x-mary-checkbox wire:change="update_area_status({{ $clearance_area_detail->clearance_detail_area_id }},{{ $clearance_area_detail->is_cleared }})" 
                                            :checked="$clearance_area_detail->is_cleared == 1"
                                            label-class="custom-label-class"/>
                                        @else
                                          <x-mary-checkbox wire:change="update_area_status({{ $clearance_area_detail->clearance_detail_area_id }},{{ $clearance_area_detail->is_cleared }})" 
                                            :checked="$clearance_area_detail->is_cleared == 1"
                                            :disabled="$clearance_area_detail->requisite_cleared_remarks == 'not_cleared'"
                                            label-class="custom-label-class"/>
                                        @endif
                                      {{-- @endif --}}
                                    @endif
                                    {{-- <x-mary-checkbox 
                                        :wire:change="'update_area_status(' . $clearance_area_detail->clearance_detail_area_id . ', $event.target.checked)'"
                                        :checked="$clearance_area_detail->is_cleared == 1"
                                        label-class="custom-label-class"  
                                    /> --}}
                                    {{-- <x-mary-checkbox 
                                        wire:change="update_area_status({{ $clearance_area_detail->clearance_detail_area_id }}, $event.target.checked)"
                                        :checked="$clearance_area_detail->is_cleared == 1"
                                        label-class="custom-label-class"  
                                    /> --}}

                                    {{-- <input type="checkbox" 
                                          wire:change="update_area_status({{ $clearance_area_detail->clearance_detail_area_id }}, $event.target.checked)"
                                          @checked($clearance_area_detail->is_cleared) /> --}}
                                    {{-- <x-mary-checkbox wire:change="update_area_status({{ $clearance_area_detail->clearance_detail_area_id }},{{ $clearance_area_detail->is_cleared }})" 
                                      :checked="$clearance_area_detail->is_cleared == 1"
                                      label-class="custom-label-class"  /> --}}
                                      {{-- <input type="checkbox" wire:change="update_area_status({{ $clearance_area_detail->clearance_detail_area_id }},{{ $clearance_area_detail->is_cleared }})"  @if($clearance_area_detail->is_cleared) checked @endif> --}}
                                  </td>
                                  <td style="padding: 8px;">
                                    {{ $clearance_area_detail->clearance_area_label }}
                                  </td>
                                  <td class="align-center" style="padding: 8px;">
                                    @if($clearance_area_detail->is_cleared == 0)
                                        <x-mary-badge value="{{ $clearance_area_detail->area_statuscode_label }}" class="badge-warning" />
                                      @else
                                        <x-mary-badge value="{{ $clearance_area_detail->area_statuscode_label }}" class="badge-primary" />
                                      @endif
                                  </td>
                                  <td class="align-center" style="padding: 8px;">
                                    @if($clearance_area_detail->is_bypass == 1)
                                      {!! $clearance_area_detail->bypass_by_name !!}
                                    @else
                                      {{ $clearance_area_detail->cleared_by_signature }}
                                    @endif
                                  </td>
                                  <td class="align-center" style="padding: 8px;">{{ $clearance_area_detail->datetime_cleared }}</td>
                                  <td class="align-center" style="padding: 8px;">{{ $clearance_area_detail->clearance_requisite_area }}</td>
                                </tr>
                              @endif
                            @endforeach
                          </tbody>
                        </table>
                      </td>
                    </tr>
                </tr>
            @endif
            
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="my-4">
			{{ $this->employee_clearance_lst->links() }}
		</div>

  </x-mary-card>

<div
    wire:loading
     wire:target="toggleRow"
    class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-75 z-50"
>
    <div class="text-center">
        <svg class="animate-spin h-10 w-10 text-blue-600 mx-auto" style="margin-top: 400px;"
             xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8v8H4z"/>
        </svg>
        <p class="mt-2 text-gray-700 font-medium">Please wait while the system is sorting the employee clearance area for you...</p>
    </div>
</div>


</div>
