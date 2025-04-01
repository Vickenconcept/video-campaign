<div>
    {{-- Be like water. --}}
    {{-- {{ $activeStep }} --}}

    <div class="space-y-3">
        <div class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5  items-center flex justify-between">
            <h5 class="font-semibold text-gray-900">Video</h5>
            <label class="relative inline-flex items-center  cursor-pointer" wire:click="update_video_response()">
                <input type="checkbox" value="1" class="sr-only peer" wire:model="allow_video_response">
                <div
                    class="w-11 z-0 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-400  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-green-400">
                </div>
            </label>
        </div>
        <div class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5  items-center flex justify-between">
            <h5 class="font-semibold text-gray-900">Text</h5>
            <label class="relative inline-flex items-center  cursor-pointer" wire:click="update_text_response()">
                <input type="checkbox" value="1" class="sr-only peer" wire:model="allow_text_response">
                <div
                    class="w-11 z-0 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-400  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-green-400">
                </div>
            </label>
        </div>
        <div class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5  items-center flex justify-between">
            <h5 class="font-semibold text-gray-900">Audio</h5>
            <label class="relative inline-flex items-center  cursor-pointer" wire:click="update_audio_response()">
                <input type="checkbox" value="1" class="sr-only peer" wire:model="allow_audio_response">
                <div
                    class="w-11 z-0 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-400  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-green-400 ">
                </div>
            </label>
        </div>
    </div>
</div>
