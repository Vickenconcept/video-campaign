<div class="space-y-6">
   
    @if ($activeTab === 'answer' || $activeTab == 'contactForm' )
        <div class="space-y-3">
            <div class="flex justify-between items-center ">
                <h5 class="text-gray-800 font-semibold">Collect contact details on this step</h5>
                <label class="relative inline-flex items-center  cursor-pointer" wire:click="update_contact_detail()">
                    <input type="checkbox" value="1" class="sr-only peer" wire:model="contact_detail">
                    <div
                        class="w-11 z-0 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-400  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-green-400">
                    </div>
                </label>
            </div>


            @if ($contact_detail && $activeTab !== 'contactForm')
                <div>
                    {{-- <p class="font-semibold text-sm">Contact form is showing on steps 1, 2</p> --}}
                    <button wire:click="update_active_tab()"
                        class="cursor-pointer font-bold text-sm underline text-green-500 hover:text-green-600 tracking-wider">
                        Edit contact form</button>
                </div>
            @endif
        </div>
    @endif


    @if ($contact_detail && $activeTab == 'contactForm')
        @if ($activeStep !== null && !empty($activeStep->form))
            <div >
                @foreach ($formFields as $index => $field)
                    {{-- @if ($field['active']) --}}
                    <div class="flex space-x-2 mb-3" wire:key="field-{{ now() }}-{{ $index }}">
                        <div class="form-control shadow capitalize ">
                            {{ $field['label'] }}
                        </div>
                        <div>
                            <button title="make this ffield required"
                                wire:click="toggleFieldRequired({{ $index }})"
                                class="p-2 rounded-lg shadow bg-gray-50 border border-slate-300 cursor-pointer size-12 text-2xl font-bold {{ $field['required'] ? 'bg-red-500 text-white' : 'bg-gray-200' }}">
                                *
                            </button>
                        </div>
                        <div>
                            <button title="hide/show this field" wire:click="toggleFieldActive({{ $index }})"
                                class="p-2 rounded-lg shadow bg-gray-50 border border-slate-300 cursor-pointer size-12 {{ $field['active'] ? 'bg-green-500 text-white' : 'bg-gray-200' }}">
                                <i class="bx {{ $field['active'] ? 'bx-show' : 'bx-hide' }} text-xl font-bold"></i>
                            </button>
                        </div>

                    </div>

           
                @endforeach
            </div>
        @else
            <p>No form fields available</p>
        @endif

    @endif
</div>
