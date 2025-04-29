<div>
  
  <x-mary-header title="My Employee Clearance" subtitle="Employee clearance detailed list." class="fs-27" style="margin-bottom:5px !important;">
    <x-slot:actions>
      {{-- <x-mary-input icon="o-bolt" placeholder="Search Employee..." wire:model.live="search"/> --}}
      <a href="javascript:history.back()" class="fs-16">← Go Back</a>
    </x-slot:actions>
  </x-mary-header>
   
  {{-- {{ session('employee_id') }} --}}

  @if(count($this->my_clearance_detail) > 0)

    @foreach ($this->my_clearance_detail as $my_clearance_detail)
      <?php 
        $employee_name = $my_clearance_detail->employee_name;
        $department_code_email_address_label = $my_clearance_detail->department_code_email_address_label;
        $clearance_description = $my_clearance_detail->clearance_description;
      ?>
    @endforeach

    <x-mary-card>

      <x-mary-card title="{{ $employee_name }}" subtitle="{{ $department_code_email_address_label }} " shadow separator>
      

        <x-mary-tabs wire:model="selectedTab">

          {{-- @foreach ($this->my_clearance_detail as $my_clearance_detail) --}}

            <x-mary-tab name="clearance-1" label="{{ $clearance_description }}" icon="s-folder">
                <div class="clearance-head-div">{{ $clearance_description }}</div>
               
                <table width="100%">
                  <tr>
                    <th class="th-uic-pink-14">#</th>
                    <th class="th-uic-pink-14">Description</th>
                    <th class="th-uic-pink-14">Status</th>
                    <th class="th-uic-pink-14">Cleared By</th>
                    <th class="th-uic-pink-14">Date Cleared</th>
                    <th class="th-uic-pink-14">Pre-requisite Area</th>
                  </tr>
                  @foreach ($this->my_clearance_detail as $result)
                    {{-- @if($employee_active_clearance_detail_lst->clearance_detail_id == $employee_active_clearance_lst->clearance_detail_id) --}}
                      <tr class="tr-border-bottom-pink h-35 custom-tr fs-14">
                        <td class="text-center align-middle custom-td">
                          &nbsp;
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;{{ $result->clearance_area_label }}</td>
                        <td class="align-center">
                          @if($result->is_cleared == 0)
                            <x-mary-badge value="{{ $result->area_statuscode_label }}" class="badge-warning" />
                          @else
                            <x-mary-badge value="{{ $result->area_statuscode_label }}" class="badge-primary" />
                          @endif
                        </td>
                        <td class="align-center">{{ $result->clearance_signature }}</td>
                        <td class="align-center">{{ $result->cleared_datetime }}</td>
                        <td class="align-center">
                          @if($result->clearance_requisite_area == '')
                            -
                          @else
                            {{ $result->clearance_requisite_area }}
                          @endif
                        </td>
                      </tr>
                    {{-- @endif --}}
                  @endforeach
                </table>
            </x-mary-tab>

            {{-- <x-mary-tab name="tricks-tab" label="HED Faculty Clearance" icon="o-sparkles">
                <div>HED Faculty Clearance</div>
            </x-mary-tab> --}}

          {{-- @endforeach --}}
        
        </x-mary-tabs>
        
        {{-- <hr class="my-5 border-base-300"> --}}
        
        {{-- <x-mary-button label="Change to Musics" @click="$wire.selectedTab = 'musics-tab'" /> --}}

      </x-mary-card>

    </x-mary-card>

  @else

    <x-mary-card>

      

    </x-mary-card>

  @endif

</div>
