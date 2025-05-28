<div class="space-y-5">
    {{-- <div wire:poll.5s="saveOptions"> --}}

    @if ($activeStep !== null)
        <div>
            <x-session-msg />
            <!-- Display existing inputs -->
            @foreach ($inputs as $key => $value)
                <div class="flex items-center gap-2 mb-2">
                    <input type="text" placeholder="Enter option" value="{{ $key }}" class="flex-1 form-control"
                        readonly>
                    <button wire:click="removeInput('{{ $key }}')" type="button"
                        class="text-red-500 hover:text-red-700 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endforeach

            <!-- Add new input -->
            <div class="flex items-center gap-2 mt-4">
                <input type="text" wire:model="newKey" placeholder="Enter new option" class="flex-1 form-control"
                    wire:keydown.enter="addInput">
                <button wire:click="addInput" type="button" class="text-green-500 hover:text-green-700 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div class="space-y-2">
        @foreach ($settings as $index => $setting)
            <div class="flex justify-between items-center border-b-2 border-gray-200 pb-3 "  >
                <h5 class="text-gray-800 font-semibold">
                    <span>{{ $setting['label'] }}</span> 
                    <span title="{{ $setting['info'] }}" class="cursor-pointer"><i class='bx bxs-help-circle'></i> </span>
                </h5>
                <label class="relative inline-flex items-center  cursor-pointer"
                    wire:click="toggleSettingStatus({{ $index }})">
                    <input type="checkbox" value="1" class="sr-only peer" wire:model="settings.{{ $index }}.status">
                    <div
                        class="w-11 z-0 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-400  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-green-400">
                    </div>
                </label>
            </div>
        @endforeach
    </div>

</div>
