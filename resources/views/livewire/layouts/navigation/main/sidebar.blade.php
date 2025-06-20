<div>
<?php
    use App\Models\Clearance;
?>



    <x-slot:sidebar
        drawer="main-drawer"
        collapsible
        collapse-text="Hide"
        class="bg-base-100 bg-inherit">

        {{-- BRAND --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center mt-5 justify-evenly">
                {{-- <img src="{{ asset('images/logo/functional_foods_logo_only.png') }}" class="h-auto w-14" /> --}}
                <div class="pl-2" >
                    <p class="text-xl">UIC iClearance System</p>
                </div>
            </div>
        </div>

        {{-- MENU --}}
        <x-mary-menu activate-by-route>

            {{-- User --}}
            @if($user = auth()->user())
                <x-mary-menu-separator />

                <x-mary-list-item :item="$user" value="first_name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
                    <x-slot:actions>
                        <x-mary-button icon="o-arrow-uturn-left" class="btn-circle btn-ghost btn-md" tooltip-left="logout" no-wire-navigate link="/logout" />
                    </x-slot:actions>
                </x-mary-list-item>


                <x-mary-menu-separator />
            @endif

            <x-mary-menu-item title="Dashboard" icon="o-home" link="/dashboard" class="py-4" />
            <x-mary-menu-separator />

            <x-mary-menu-item title="My Clearance(s)" icon="o-home" link="/my-clearance" class="py-4" />
                <x-mary-menu-separator />

            @if(auth()->user()->hasRole(1))
                <x-mary-menu-item title="Employee Clearance(s)" icon="o-home" link="/clearance-management" class="py-4" />
                <x-mary-menu-separator />

                {{-- <x-mary-menu-sub title="Clearance(s)" icon="o-cog-6-tooth" open>
                    <x-mary-menu-item title="HED Faculty" icon="o-home" link="/hed" class="mt-3.5"/>
                    <x-mary-menu-item title="BED Faculty" icon="o-home" link="/bed" />
                    <x-mary-menu-item title="Support Service Personnel" icon="o-home" link="/ssp"/>
                    <x-mary-menu-item title="Maintenance" icon="o-home" link="/maintenance"/>
                    <x-mary-menu-item title="BED Student" icon="o-home" link="/bed-student"/>
                </x-mary-menu-sub> --}}
                {{-- <x-mary-menu-separator /> --}}

                <x-mary-menu-sub title="Clearance Libraries" icon="o-cog-6-tooth" open>
                    <x-mary-menu-item title="Clearance Area" icon="o-home" link="/area" class="mt-3.5"/>
                    <x-mary-menu-item title="Clearance Type" icon="o-home" link="/type" />
                    <x-mary-menu-item title="Manage Clearance(s)" icon="o-home" link="/manage-clearance"/>
                    <x-mary-menu-item title="Manage Role(s)" icon="o-home" link="/roles"/>
                    <x-mary-menu-item title="Permission(s) Request" icon="o-home" link="/permission-request"/>
                    <x-mary-menu-item title="System Info" icon="o-home" link="/info"/>
                </x-mary-menu-sub>

            @elseif(auth()->user()->hasRole(2))

							<x-mary-menu-item title="Employee Clearance(s)" icon="o-home" link="/individual-employee-clearance" class="py-4" />

							<x-mary-menu-separator />

                {{-- <x-mary-menu-sub title="Clearance(s)" icon="o-cog-6-tooth" open>
									@if(count(Clearance::on('iclearance_connection')->where('is_open',1)->where('clearance_type_id', 3)->get('clearance_type_id')) > 0)
										<x-mary-menu-item title="HED Faculty" icon="o-home" link="/hed" class="mt-3.5"/>
									@endif
									@if(count(Clearance::on('iclearance_connection')->where('is_open',1)->where('clearance_type_id', 4)->get('clearance_type_id')) > 0)
										<x-mary-menu-item title="Support Service Personnel" icon="o-home" link="/ssp"/>
									@endif
									@if(count(Clearance::on('iclearance_connection')->where('is_open',1)->where('clearance_type_id', 5)->get('clearance_type_id')) > 0)
										<x-mary-menu-item title="Maintenance" icon="o-home" link="/maintenance"/>
									@endif
									@if(count(Clearance::on('iclearance_connection')->where('is_open',1)->where('clearance_type_id', 2)->get('clearance_type_id')) > 0)
										<x-mary-menu-item title="BED Student" icon="o-home" link="/bed-student"/>
									@endif
									@if(count(Clearance::on('iclearance_connection')->where('is_open',1)->where('clearance_type_id', 1)->get('clearance_type_id')) > 0)
										<x-mary-menu-item title="BED Faculty" icon="o-home" link="/bed" />
									@endif
                </x-mary-menu-sub> --}}

            @else

            @endif

						{{-- <x-mary-menu-separator /> --}}
						<x-mary-menu-item title="Request Access Permission" icon="o-home" link="/request-access" class="py-4" />

            <x-mary-menu-separator />
            <x-mary-menu-item title="FAQ" icon="o-home" link="/faq" class="py-4" />

            {{-- @if(auth()->user()->getRoleAttribute()->role_id == 2)
                 <x-mary-menu-item title="Food Substantiation" icon="o-home" link="/contributor-substantiation" class="py-4" />
            @endif --}}

            {{-- @if(auth()->user()->getRoleAttribute()->role_id == 1)
                <x-mary-menu-sub title="Food Substantiation" icon="o-cog-6-tooth" open>
                    <x-mary-menu-item title="For Approval" icon="o-home" link="/food-substantiation" class="mt-3.5"/>
                    <x-mary-menu-item title="Approved" icon="o-home" link="/approved-substantiation" />
                </x-mary-menu-sub>

                <x-mary-menu-separator />

                <x-mary-menu-item title="Foods" icon="o-list-bullet" link="/foods" />

                <x-mary-menu-item title="Product Brand" icon="o-list-bullet" link="/brand" />

                <x-mary-menu-item title="Product" icon="o-list-bullet" link="/product" />

                <x-mary-menu-item title="Company" icon="o-list-bullet" link="/company" />

                <x-mary-menu-item title="Health Claim" icon="o-list-bullet" link="/health-claim" />

                <x-mary-menu-item title="Health Claim Category" icon="o-list-bullet" link="/health-claim-category" />

                <x-mary-menu-item title="File Record(s) Type" icon="o-list-bullet" link="/file-record-type" />

                <x-mary-menu-item title="Food Classification" icon="o-list-bullet" link="/food-classification" />

                <x-mary-menu-item title="Food Parts" icon="o-list-bullet" link="/food-parts" />

                <x-mary-menu-item title="Functional Factor" icon="o-list-bullet" link="/functional-factor" />

                <x-mary-menu-item title="Product Form" icon="o-list-bullet" link="/product-form" />

                <x-mary-menu-item title="Test Classification" icon="o-list-bullet" link="/test-classification" />

            @endif --}}

        </x-mary-menu>
    </x-slot:sidebar>
</div>
