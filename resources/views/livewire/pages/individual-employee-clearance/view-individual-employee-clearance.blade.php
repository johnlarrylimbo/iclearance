<div>
  
  <x-mary-header title="Employee Clearance(s)" subtitle="Employee clearance list." class="fs-27" style="margin-bottom:5px !important;">
    <x-slot:actions>
      {{-- <x-mary-input icon="o-bolt" placeholder="Search Employee..." wire:model.live="search"/> --}}
      <a href="javascript:history.back()" class="fs-16">← Go Back</a>
    </x-slot:actions>
  </x-mary-header>
   
  {{-- {{ session('employee_id') }} --}}

  @if(count($this->employee_information) > 0)

    @foreach ($this->employee_information as $employee_information)
      <?php 
        $employee_name = $employee_information->employee_name;
        $department_code_email_address_label = $employee_information->department_code_email_address_label;
      ?>
    @endforeach

    <x-mary-card>

      <x-mary-card title="{{ $employee_name }}" subtitle="{{ $department_code_email_address_label }} " shadow separator>
      

        <x-mary-tabs wire:model="selectedTab">

          @foreach ($this->employee_active_clearance_lst as $employee_active_clearance_lst)

            <x-mary-tab name="{{ $employee_active_clearance_lst->clearance_lst_num }}" label="{{ $employee_active_clearance_lst->clearance_description }}" icon="s-folder">
                <div class="clearance-head-div">{{ $employee_active_clearance_lst->clearance_description }}</div>
                <div class="instruction-div">Instruction: Please <strong>check</strong> the checkbox to clear/unclear clearance area.</div>
                <table width="100%">
                  <tr>
                    <th class="th-uic-pink-14">#</th>
                    <th class="th-uic-pink-14">Description</th>
                    <th class="th-uic-pink-14">Status</th>
                    <th class="th-uic-pink-14">Cleared By</th>
                    <th class="th-uic-pink-14">Date Cleared</th>
                  </tr>
                  @foreach ($this->employee_active_clearance_detail_lst as $employee_active_clearance_detail_lst)
                    @if($employee_active_clearance_detail_lst->clearance_detail_id == $employee_active_clearance_lst->clearance_detail_id)
                      <tr class="tr-border-bottom-pink h-35 custom-tr fs-14">
                        <td class="text-center align-middle custom-td">
                          @if($employee_active_clearance_detail_lst->clearance_type_id == 1)
                          {{-- Faculty BED --}}
                            @if($employee_active_clearance_detail_lst->is_bed == 0) 
                              <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                :disabled="$employee_active_clearance_detail_lst->is_bed == 0"
                                label-class="custom-label-class"/>
                            @else
                              @if($employee_active_clearance_detail_lst->requisite_cleared_remarks == 'not_requisite') 
                                <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                  :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                  label-class="custom-label-class"/>
                              @else
                                <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                  :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                  :disabled="$employee_active_clearance_detail_lst->requisite_cleared_remarks == 'not_cleared'"
                                  label-class="custom-label-class"/>
                              @endif
                            @endif
                            {{-- <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                              :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                              :disabled="$employee_active_clearance_detail_lst->is_bed == 0"
                              label-class="custom-label-class"/> --}}
                          @elseif($employee_active_clearance_detail_lst->clearance_type_id == 2)
                          {{-- Student Clearance --}}
                            @if($employee_active_clearance_detail_lst->is_student_bed == 0) 
                              <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                :disabled="$employee_active_clearance_detail_lst->is_student_bed == 0"
                                label-class="custom-label-class"/>
                            @else
                              @if($employee_active_clearance_detail_lst->requisite_cleared_remarks == 'not_requisite') 
                                <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                  :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                  label-class="custom-label-class"/>
                              @else
                                <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                  :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                  :disabled="$employee_active_clearance_detail_lst->requisite_cleared_remarks == 'not_cleared'"
                                  label-class="custom-label-class"/>
                              @endif
                            @endif
                              {{-- <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                :disabled="$employee_active_clearance_detail_lst->is_student_bed == 0"
                                label-class="custom-label-class"/> --}}
                          @elseif($employee_active_clearance_detail_lst->clearance_type_id == 3)
                          {{-- Faculty HED --}}
                            @if($employee_active_clearance_detail_lst->is_hed == 0) 
                              <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                :disabled="$employee_active_clearance_detail_lst->is_hed == 0"
                                label-class="custom-label-class"/>
                            @else
                              @if($employee_active_clearance_detail_lst->requisite_cleared_remarks == 'not_requisite') 
                                <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                  :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                  label-class="custom-label-class"/>
                              @else
                                <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                  :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                  :disabled="$employee_active_clearance_detail_lst->requisite_cleared_remarks == 'not_cleared'"
                                  label-class="custom-label-class"/>
                              @endif
                            @endif
                                {{-- <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                  :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                  :disabled="$employee_active_clearance_detail_lst->is_hed == 0"
                                  label-class="custom-label-class"/> --}}
                          @elseif($employee_active_clearance_detail_lst->clearance_type_id == 4) 
                          {{-- ssp clearance --}}
                            @if($employee_active_clearance_detail_lst->is_ssp == 0) 
                              <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                :disabled="$employee_active_clearance_detail_lst->is_ssp == 0"
                                label-class="custom-label-class"/>
                            @else
                              @if($employee_active_clearance_detail_lst->requisite_cleared_remarks == 'not_requisite') 
                                <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                  :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                  label-class="custom-label-class"/>
                              @else
                                <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                  :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                  :disabled="$employee_active_clearance_detail_lst->requisite_cleared_remarks == 'not_cleared'"
                                  label-class="custom-label-class"/>
                              @endif
                            @endif
                          @elseif($employee_active_clearance_detail_lst->clearance_type_id == 56)
                            {{-- Maintenance HED --}}
                              @if($employee_active_clearance_detail_lst->is_admin == 0) 
                                <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                  :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                  :disabled="$employee_active_clearance_detail_lst->is_admin == 0"
                                  label-class="custom-label-class"/>
                              @else
                                @if($employee_active_clearance_detail_lst->requisite_cleared_remarks == 'not_requisite') 
                                  <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                    :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                    label-class="custom-label-class"/>
                                @else
                                  <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                    :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                    :disabled="$employee_active_clearance_detail_lst->requisite_cleared_remarks == 'not_cleared'"
                                    label-class="custom-label-class"/>
                                @endif
                              @endif
                                  {{-- <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                                    :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                                    :disabled="$employee_active_clearance_detail_lst->is_hed == 0"
                                    label-class="custom-label-class"/> --}}
                          {{-- @else
                            <x-mary-checkbox wire:change="update_clearance_detail_status({{ $employee_active_clearance_detail_lst->clearance_detail_area_id }},{{ $employee_active_clearance_detail_lst->is_cleared }})" 
                              :checked="$employee_active_clearance_detail_lst->is_cleared == 1"
                              disabled="disabled"
                              label-class="custom-label-class"/> --}}
                          @endif
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;{{ $employee_active_clearance_detail_lst->clearance_area_label }}</td>
                        <td class="align-center">
                          @if($employee_active_clearance_detail_lst->is_cleared == 0)
                            <x-mary-badge value="{{ $employee_active_clearance_detail_lst->area_statuscode_label }}" class="badge-warning" />
                          @else
                            <x-mary-badge value="{{ $employee_active_clearance_detail_lst->area_statuscode_label }}" class="badge-primary" />
                          @endif
                        </td>
                        <td class="align-center">{{ $employee_active_clearance_detail_lst->cleared_by_signature }}</td>
                        <td class="align-center">{{ $employee_active_clearance_detail_lst->datetime_cleared }}</td>
                      </tr>
                    @endif
                  @endforeach
                </table>
            </x-mary-tab>

            {{-- <x-mary-tab name="tricks-tab" label="HED Faculty Clearance" icon="o-sparkles">
                <div>HED Faculty Clearance</div>
            </x-mary-tab> --}}

          @endforeach
        
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
