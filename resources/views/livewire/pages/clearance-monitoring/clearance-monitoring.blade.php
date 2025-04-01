<div>
  
  <x-mary-header title="Employee Clearance Management" subtitle="Employee clearance monitoring and management dashboard." >
    <x-slot:actions>
      <x-mary-input icon="o-bolt" placeholder="Search Employee..." wire:model.live="search_employee_keyword"/>
    </x-slot:actions>
  </x-mary-header>

  <x-mary-card shadow separator>


  </x-mary-card>

  {{-- {{ auth()->user()->hasClearanceAreaRole(1) }}--}}
  {{-- {{ auth()->user() }} --}}
  {{-- {{ auth()->user()->account_role }} --}}

  {{-- <div class="grid grid-cols-4 gap-6 sm:grid-cols-2 lg:grid-cols-4">
      <x-mary-stat title="Messages" value="44" icon="o-envelope" tooltip="Hello" />

      <x-mary-stat
          title="Sales"
          description="This month"
          value="22.124"
          icon="o-arrow-trending-up"
          tooltip-bottom="There" />

      <x-mary-stat
          title="Lost"
          description="This month"
          value="34"
          icon="o-arrow-trending-down"
          tooltip-left="Ops!" />

      <x-mary-stat
          title="Sales"
          description="This month"
          value="22.124"
          icon="o-arrow-trending-down"
          class="text-orange-500"
          color="text-pink-500"
          tooltip-right="Gosh!" />
  </div> --}}

</div>