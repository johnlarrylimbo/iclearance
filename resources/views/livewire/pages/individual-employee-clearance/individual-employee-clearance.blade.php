<div>
  
  <x-mary-header title="Employee Clearance(s)" subtitle="Employee clearance management dashboard." class="fs-27">
    <x-slot:actions>
      <x-mary-input icon="o-bolt" placeholder="Search Employee..." wire:model.live="search"/>
    </x-slot:actions>
  </x-mary-header>
   

  <x-mary-card shadow separator>

    <div class="my-4">
			{{ $this->individual_employee_clearance_detail->links() }}
		</div>

    <table width="100%" class="table mb-4 table-striped" style="table-layout: fixed;">
      <thead>
        <tr class="fs-14 pink h-2rem">
          <th class="align-center w-5">Employee No.</th>
          <th class="align-center w-20">Employee Name</th>
          <th class="align-center w-5">Gender</th>
          <th class="align-center w-10">Email Address</th>
          <th class="align-center w-5">Department</th>
          <th class="align-center w-15">Manage</th>
        </tr>
      </thead>
      <tbody>
        @if(count($this->individual_employee_clearance_detail) == 0)
          <tr class="fs-13 border-btm content-tr">
            <td class="align-center" colspan="7">No employee record(s) found.</td>
          </tr>
				@else
          @foreach ($this->individual_employee_clearance_detail as $result)
            <tr class="fs-13 border-btm content-tr">
              <td class="align-center vertical-align-top">{{ $result->employee_no }}</td>
              <td class="align-left vertical-align-top">{{ $result->employee_name }}</td>
              <td class="align-center vertical-align-top">{{ $result->gender }}</td>
              <td class="align-center vertical-align-top">{{ $result->email_address }}</td>
              <td class="align-center vertical-align-top">{{ $result->department_code }}</td>
              <td class="align-center vertical-align-top">
                {{-- <a href="/clearance-detail/{{ $result->clearance_id }}" class="btn-success btn-sm align-center">{{ svg('heroicon-s-users') }}</a> --}}
                <x-mary-button icon="o-list-bullet" 
                                title="View employee clearance(s)."
                                wire:click="openViewIndividualEmployeeClearancesWindow({{ $result->employee_id }})" 
                                spinner 
                                class="btn-success btn-sm align-center" />
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="my-4">
			{{ $this->individual_employee_clearance_detail->links() }}
		</div>

  </x-mary-card>


</div>
