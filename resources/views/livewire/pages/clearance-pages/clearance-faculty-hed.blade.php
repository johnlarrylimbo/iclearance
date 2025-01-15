
<div class="py-12">

  <x-mary-header title="HED Faculty Clearance" subtitle="HED Faculty Clearance result list">
    <x-slot:actions>
      <x-mary-input icon="o-bolt" placeholder="Search..." wire:model.live="search"/>
      {{-- <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.addClearanceAreaModal = true" /> --}}
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
          <th class="align-center w-20">Manage</th>
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
                {{ $result->clearance_code }}
              </td>
              <td class="align-center vertical-align-top"">
                {{ $result->period_description }}
              </td>
              <td class="align-center vertical-align-top"">
                @if($result->is_open == 'Open')
                  <x-mary-badge value="{{ $result->is_open }}" class="badge-primary" />
                @else
                  <x-mary-badge value="{{ $result->is_open }}" class="badge-warning" />
                @endif
              </td>
              <td class="align-center vertical-align-top"">
                <x-mary-button icon="m-numbered-list" 
                                wire:click="openClearanceAreaItemModal({{ $result->clearance_id }})" 
                                title="View clearance area(s) information."
                                spinner 
                                class="btn-success btn-sm align-center" />&nbsp;
                <x-mary-button icon="m-users" 
                                wire:click="openClearanceEmployeeRecordModal({{ $result->clearance_id }})" 
                                title="View employee clearance record."
                                spinner 
                                class="btn-success btn-sm align-center" />
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

  <x-mary-modal wire:model="showClearanceAreaItemModal" class="backdrop-blur" title="{{ $title  }}" separator>

    <table width="100%" class="table mb-4 table-striped" style="table-layout: fixed;">
      <thead>
        <tr class="fs-14 pink h-2rem">
          <th class="align-center w-3">#</th>
          <th class="align-center w-30">Description</th>
          <th class="align-center w-15">Default Status</th>
          <th class="align-center w-15">Order</th>
        </tr>
      </thead>
      <tbody>
        @if(count($this->clearance_area_item_by_clearance_id) == 0)
          <tr class="fs-13 border-btm content-tr">
            <td class="align-center fs-14" colspan="4">No clearance area item(s) found.</td>
          </tr>
				@else
          @foreach ($this->clearance_area_item_by_clearance_id as $result)
            <tr class="fs-13 border-btm content-tr">
              <td class="align-center vertical-align-top">&nbsp;</td>
              <td class="align-left vertical-align-top"">{{ $result->clearance_area_label }}</td>
              <td class="align-center vertical-align-top"">{{ $result->default_cleared_status }}</td>
              <td class="align-center vertical-align-top"">{{ $result->order_type_label }}</td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <x-slot:actions>
        <x-mary-button label="Cancel" wire:click="showClearanceAreaItemModal = false" />
    </x-slot:actions>
  </x-mary-modal>

  <x-mary-modal wire:model="showClearanceEmployeeRecordModal" class="backdrop-blur" title="{{ $title  }}" separator>

    <x-mary-header>
      <x-slot:actions>
        <x-mary-input icon="o-bolt" placeholder="Search..." wire:model.live="search_employee"/>
        {{-- <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.addClearanceAreaModal = true" /> --}}
      </x-slot:actions>
    </x-mary-header>

    <table width="100%" class="table mb-4 table-striped m-top" style="table-layout: fixed;">
      <thead>
        <tr class="fs-14 pink h-2rem">
          <th class="align-center w-3">#</th>
          <th class="align-center w-30">Employee Name</th>
          <th class="align-center w-15">Default Status</th>
          <th class="align-center w-15">Manage</th>
        </tr>
      </thead>
      <tbody>
        @if(count($this->clearance_employee_record_by_clearance_id) == 0)
          <tr class="fs-13 border-btm content-tr">
            <td class="align-center fs-14" colspan="4">No clearance employee record(s) found.</td>
          </tr>
				@else
          @foreach ($this->clearance_employee_record_by_clearance_id as $result)
            <tr class="fs-13 border-btm content-tr">
              <td class="align-center vertical-align-top">{{ $result->row_num }}</td>
              <td class="align-left vertical-align-top"">{{ $result->employee_name }}</td>
              <td class="align-center vertical-align-top"">
                @if($result->cleared_status == 'Cleared')
                  <x-mary-badge value="{{ $result->cleared_status }}" class="badge-primary" />
                @else
                  <x-mary-badge value="{{ $result->cleared_status }}" class="badge-warning" />
                @endif
              </td>
              <td class="align-center vertical-align-top"">
                <x-mary-button icon="m-eye" 
                                wire:click="openEmployeeClearanceRecordModal({{ $result->clearance_detail_id }})" 
                                title="View clearance area(s) information."
                                spinner 
                                class="btn-success btn-sm align-center" />
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <x-slot:actions>
        <x-mary-button label="Cancel" wire:click="showClearanceEmployeeRecordModal = false" />
    </x-slot:actions>
  </x-mary-modal>

  <x-mary-modal wire:model="showEmployeeClearanceRecordModal" class="backdrop-blur" title="{{ $employee_clearance_title  }}" separator>

    Note: Clearance area(s) with <strong>"Any" order type must be cleared first.</strong>
    <table width="100%" class="table mb-4 table-striped m-top" style="table-layout: fixed;">
      <thead>
        <tr class="fs-14 pink h-2rem">
          <th class="align-center w-30">Clearance Area</th>
          <th class="align-center w-25">Status</th>
          <th class="align-center w-15">Cleared by</th>
          <th class="align-center wd-12">Action</th>
        </tr>
      </thead>
      <tbody>
        @if(count($this->employee_clearance_area_item_by_detail_id) == 0)
          <tr class="fs-13 border-btm content-tr">
            <td class="align-center fs-14" colspan="5">No clearance area item record(s) found.</td>
          </tr>
				@else
          @foreach ($this->employee_clearance_area_item_by_detail_id as $result)
            <tr class="fs-13 border-btm content-tr">
              <td class="align-left vertical-align-top"">
                <strong>{{ $result->clearance_area_label }}</strong><br />
                Order Type : ({{ $result->order_type_label }})
              </td>
              <td class="align-center vertical-align-top"">
                @if($result->cleared_status == 'Cleared')
                  <x-mary-badge value="{{ $result->cleared_status }}" class="badge-primary" />
                @else
                  <x-mary-badge value="{{ $result->cleared_status }}" class="badge-warning" />
                @endif
              </td>
              <td class="align-center vertical-align-top"">{{ $result->cleared_by_initial }}<br />{{ $result->cleared_date }}</td>
              <td class="align-center vertical-align-top"">
                @if($result->order_type_id == 1)
                  @if($result->is_cleared == 1)
                  @else
                    @if($result->area_permission_status == 'not_granted')
                    @else
                      <x-mary-button icon="m-eye" 
                                    wire:click="update_clearance_detail_area_status({{ $result->clearance_detail_area_id }})" 
                                    title="View clearance area(s) information."
                                    spinner 
                                    class="btn-success btn-sm align-center" />
                    @endif
                  @endif
                @else
                  Not Available
                @endif
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <x-slot:actions>
        <x-mary-button label="Cancel" wire:click="showEmployeeClearanceRecordModal = false" />
    </x-slot:actions>
  </x-mary-modal>

  
</div>



    








