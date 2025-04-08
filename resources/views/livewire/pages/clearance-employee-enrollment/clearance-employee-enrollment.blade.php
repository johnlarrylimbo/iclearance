<div>
  
  <x-mary-header title="Clearance Employee Enrollment" subtitle="Employee clearance management dashboard." >
    <x-slot:actions>
      <x-mary-input icon="o-bolt" placeholder="Search Employee..." wire:model.live="search"/>
    </x-slot:actions>
  </x-mary-header>

  <x-mary-card shadow separator>

    <div class="my-4">
			{{ $this->employee_lst->links() }}
		</div>

    <table width="100%" class="table mb-4 table-striped" style="table-layout: fixed;">
      <thead>
        <tr class="fs-14 pink h-2rem">
          <th class="align-center wd-5">#</th>
          <th class="align-center w-5">Employee No.</th>
          <th class="align-center w-20">Employee Name</th>
          <th class="align-center w-5">Gender</th>
          <th class="align-center w-10">Email Address</th>
          <th class="align-center w-5">Department</th>
          <th class="align-center w-15">Manage</th>
        </tr>
      </thead>
      <tbody>
        @if(count($this->employee_lst) == 0)
          <tr class="fs-13 border-btm content-tr">
            <td class="align-center" colspan="7">No employee record(s) found.</td>
          </tr>
				@else
          @foreach ($this->employee_lst as $result)
            <tr class="fs-13 border-btm content-tr">
              <td class="align-center vertical-align-top">{{ $result->row_num }}</td>
              <td class="align-center vertical-align-top">{{ $result->employee_no }}</td>
              <td class="align-left vertical-align-top">{{ $result->employee_name }}</td>
              <td class="align-center vertical-align-top">{{ $result->gender }}</td>
              <td class="align-center vertical-align-top">{{ $result->email_address }}</td>
              <td class="align-center vertical-align-top">{{ $result->department_code }}</td>
              <td class="align-center vertical-align-top">
                <x-mary-button icon="o-user-group" 
                                wire:click="populate_employee_clearance_area({{ $result->employee_id }})" 
                                spinner 
                                class="btn-success btn-sm align-center" />
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>


    <div class="my-4">
			{{ $this->employee_lst->links() }}
		</div>


  </x-mary-card>



  <x-mary-modal wire:model="PopulateEmployeeClearanceAreaModal" class="backdrop-blur">
		<x-mary-form wire:submit.prevent="populate_clearance_area_details" no-separator>

			<x-mary-input type="hidden" wire:model="add_clearance_id" id="add_clearance_id" />
      <x-mary-input type="hidden" wire:model="employee_id" id="employee_id" />

			<x-mary-input label="Employee No." wire:model="employee_no" id="employee_no" disabled/>

      <x-mary-input label="Employee Name" wire:model="employee_name" id="employee_name" disabled/>

      <x-mary-input label="Email Address" wire:model="email_address" id="email_address" disabled/>

      <x-mary-input label="Department Code" wire:model="department_code" id="department_code" disabled/>

			<x-slot:actions>
				<x-mary-button label="Cancel" @click="$wire.PopulateEmployeeClearanceAreaModal = false"/>
				<x-mary-button label="Populate Clearance Area Detail" class="btn-primary" type="submit" spinner="populate_clearance_area_details" />
			</x-slot:actions>

	</x-mary-form>
</x-mary-modal>


</div>