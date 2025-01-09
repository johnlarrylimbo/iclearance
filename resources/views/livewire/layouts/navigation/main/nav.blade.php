<div>
    <x-mary-nav sticky class="lg:hidden">
        <x-slot:brand>
            {{-- <div class="pt-5 ml-5">Functional Foods PH</div> --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-evenly">
                    <img src="{{ asset('images/logo/functional_foods_logo_only.png') }}" class="h-auto w-14" />
                    <div class="pl-2" >
                        <p class="text-xl">Functional Foods PH</p>
                    </div>
                </div>
            </div>
        </x-slot:brand>

        <x-slot:actions>
            <label for="main-drawer" class="mr-3 lg:hidden">
                <x-mary-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-mary-nav>
</div>
