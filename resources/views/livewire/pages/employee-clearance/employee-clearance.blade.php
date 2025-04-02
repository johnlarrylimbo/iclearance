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
          <th class="align-center w-20">Employee Name</th>
          @if(count($this->clearance_area_lst) == 0)
            <th class="align-center" colspan="5">No available assigned clearance area</th>
          @else
            @foreach ($this->clearance_area_lst as $clearance_area_lst)
              <th class="align-center wd-10 word-wrap vertical-align-top">{{ $clearance_area_lst->clearance_area_description }}</th>
            @endforeach
          @endif
        </tr>
      </thead>
      <tbody>
        @if(count($this->employee_clearance_lst) == 0)
          <tr class="fs-13 border-btm content-tr">
            <td class="align-center" colspan="9">No clearance record(s) found.</td>
          </tr>
				@else
          @foreach ($this->employee_clearance_lst as $result)
            <tr class="fs-13 border-btm content-tr">
              <td class="align-center vertical-align-top">{{ $result->row_num }}</td>
              <td class="align-left vertical-align-top">{{ $result->employee_name }}</td>
              @if(count($this->loaded_employee_clearance_area) == 0)
                <th class="align-center" colspan="5">No available loaded clearance area</th>
              @else
                @foreach ($this->loaded_employee_clearance_area as $loaded_employee_clearance_area)
                  @if($result->clearance_detail_id == $loaded_employee_clearance_area->clearance_detail_id)
                    <td class="align-center vertical-align-top">
                      <x-mary-checkbox wire:change="update_area_status({{ $result->clearance_detail_id }},{{ $loaded_employee_clearance_area->clearance_area_id }},{{ $loaded_employee_clearance_area->is_cleared }})" 
                                      :checked="$loaded_employee_clearance_area->is_cleared == 1"
                                        />
                    </td>
                  @endif
                  {{-- <td class="align-center wd-10 word-wrap vertical-align-top">{{ $clearance_area_lst->clearance_area_description }}</td> --}}
                @endforeach
              @endif
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="my-4">
			{{ $this->employee_clearance_lst->links() }}
		</div>

  </x-mary-card>


</div>