<div class="space-y-8 pt-10" x-data="{ upload_type: 'avatar_video' }">
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
   

    <div class="flex justify-center mb-5" wire:transition>
        <button type="button" class="whitespace-nowrap flex flex-wrap" x-show="upload_type == 'upload'"
            style="display: none">
            <span
                class="uppercase text-white border border-gray-900  bg-gray-900 cursor-pointer px-5 py-2 rounded-full text-sm block md:-mr-10 z-10"
                @click="upload_type = 'upload'">Upload</span>
            <span
                class="uppercase cursor-pointer border border-gray-800 pl-5 md:pl-16 pr-5 py-2  rounded-full text-sm   bg-white flex items-center space-x-2"
                @click="upload_type = 'avatar_video'">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                    </svg>
                </span>
                <span>Use AI Avatar</span>
            </span>
        </button>
        <button type="button" class="whitespace-nowrap flex flex-wrap" x-show="upload_type == 'avatar_video'"
            style="display: none">
            <span
                class="uppercase cursor-pointer  border  border-gray-800  bg-white  pr-5 md:pr-16 pl-5 py-2 rounded-full text-sm block "
                @click="upload_type = 'upload'">Upload</span>
            <span
                class="uppercase text-white border  border-gray-900 bg-gray-900 cursor-pointer pl-16 px-5 py-2  rounded-full text-sm   md:-ml-10 z-10  flex items-center space-x-2"
                @click="upload_type = 'avatar_video'">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                    </svg>
                </span>
                <span>Use AI Avatar</span>
            </span>
        </button>
    </div>


    <div class="bg-slate-100 flex justify-center py-10 rounded-md border-2 border-gray-300" x-show="upload_type == 'upload'" wire:transition>
        {{-- <x-cloudinary::widget>Upload Files</x-cloudinary::widget> --}}
        <div class="text-center">
            <button id="upload_widget" class="cloudinary-button">Upload files</button>
            <p class="text-sm font-semibold mt-2 text-slate-700">Click button to upload video , max of 100mb</p>
        </div>


    </div>

    <div x-data="{
        tab: 'avatar',
        selectedAvatar: null,
        selectedVoice: null,
        isGenerating: false,
        checkInterval: null,
    
        init() {
            Livewire.on('videoGenerationStarted-{{ $activeStep->id }}', () => {
                this.isGenerating = true;
                // Start polling for status
                this.checkInterval = setInterval(() => {
                    @this.checkVideoStatus();
                }, 5000); // Check every 5 seconds
            });
    
            Livewire.on('video-generation-complete-{{ $activeStep->id }}', ({
                videoUrl
            }) => {
                this.isGenerating = false;
                this.tab = 'video';
                if (this.checkInterval) {
                    clearInterval(this.checkInterval);
                }
            });
        }
    }" class="">

        <div class="relative" x-show="upload_type == 'avatar_video'">
            <div x-show="isGenerating" style="display: none"
                class="absolute z-20 left-0 top-0 h-full w-full bg-white bg-opacity-90 flex items-center justify-center">

                <div>
                    <div class="">
                        <img src="{{ asset('images/moving_ball.gif') }}" alt="" style="opacity: 0.8;">
                    </div>

                    <p class="font-medium" x-data="{
                        messages: [
                            'Initializing video generation...',
                            'Processing your content...',
                            'Creating video frames...',
                            'Adding finishing touches...',
                            'Almost there...'
                        ],
                        currentIndex: 0,
                        intervalId: null
                    }" x-init="intervalId = setInterval(() => {
                        currentIndex = (currentIndex + 1) % messages.length;
                    }, 4000);
                    
                    Livewire.on('video-generation-complete-{{ $activeStep->id }}', ({ videoUrl }) => {
                        clearInterval(intervalId);
                    });"
                        x-text="messages[currentIndex]"></p>
                </div>
            </div>
            <div class="p-2 h-80 overflow-y-auto">
                <div class="">
                    <div>
                        @error('video')
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                                role="alert">
                                <span class="block sm:inline">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <!-- Avatars Section -->
                    <div class="mb-4" x-show="tab === 'avatar'">
                        <div class="flex justify-between items-center">
                            <div class="flex justify-end space-x-2">
                                <button type="button" @click="tab = 'voice'" :disabled="selectedAvatar === null"
                                    :class="{
                                        'bg-slate-900': selectedAvatar !==
                                            null,
                                        'bg-gray-400 cursor-not-allowed': selectedAvatar === null
                                    }"
                                    class="text-white px-4 py-2 rounded-md cursor-pointer">Next</button>
                                <button type="button" @click="tab = 'video'"
                                    class="bg-slate-900 text-white px-4 py-2 rounded-md cursor-pointer">Response</button>
                            </div>

                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Select Avatar</h3>
                        <div class="grid grid-cols-3 gap-2">
                            <template x-for="(avatar, index) in $wire.avatars" :key="avatar.id">
                                <div x-show="index > 0"
                                    class="cursor-pointer p-2 rounded-lg transition-all duration-200 border border-gray-300 rounded-sm bg-slate-100 hover:shadow-md"
                                    :class="{ 'ring-2 ring-slate-900 bg-slate-50': selectedAvatar === avatar.id }"
                                    @click="selectedAvatar = avatar.id; $wire.selectAvatar(avatar.id)">
                                    <img :src="avatar.image_url ? avatar.image_url : 'https://placehold.co/60x60'"
                                        :alt="avatar.name" class="w-full h-auto rounded-lg">
                                    <p class="text-sm text-center mt-1" x-text="avatar.name"></p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Voices Section -->
                    <div x-show="tab === 'voice'">
                        <div class="flex justify-between items-center">
                            <div class="flex justify-end space-x-2">
                                <button type="button" @click="tab = 'avatar'; $wire.selectAvatar(null)"
                                    class="bg-slate-900 text-white px-4 py-2 rounded-md cursor-pointer">Prev</button>

                                <button type="button" @click="tab = 'script'" :disabled="selectedVoice === null"
                                    :class="{
                                        'bg-slate-900': selectedVoice !==
                                            null,
                                        'bg-gray-400 cursor-not-allowed': selectedVoice === null
                                    }"
                                    class="text-white px-4 py-2 rounded-md cursor-pointer">Next</button>
                                <button type="button" @click="tab = 'video'"
                                    class="bg-slate-900 text-white px-4 py-2 rounded-md cursor-pointer">Response</button>
                            </div>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Select Voice</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <template x-for="voice in $wire.voices" :key="voice.id">
                                <div class="cursor-pointer p-3 border rounded-lg transition-all duration-200  bg-slate-100 hover:shadow-md"
                                    :class="{ 'ring-2 ring-slate-900 bg-slate-50': selectedVoice === voice.id }"
                                    @click="selectedVoice = voice.id; $wire.selectVoice(voice.id)">
                                    <div class="flex items-center space-x-1">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-sm" x-text="voice.name"></p>
                                            <p class="text-sm text-gray-500" x-text="voice.language"></p>
                                            <p class="text-xs text-gray-700" x-text="voice.gender"></p>
                                        </div>
                                    </div>
                                    <div x-data="{ isPlaying: false }" class="mt-2">
                                        <button
                                            class="w-full px-3 py-1 text-sm text-[#39ac73] border border-gray-900 rounded-md hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
                                            @click.stop="isPlaying = true; $wire.previewVoice(voice.id); setTimeout(() => { isPlaying = false; }, 5000)"
                                            :disabled="isPlaying">
                                            <span x-text="isPlaying ? 'Playing...' : 'Response'"></span>
                                        </button>
                                    </div>


                                </div>
                            </template>
                        </div>
                    </div>

                    <div x-show="tab === 'script'">
                        <div class="flex justify-between items-center">
                            <div class="flex justify-end space-x-2">

                                <button type="button" @click="tab = 'voice'; $wire.selectVoice(null)"
                                    class="bg-slate-900 text-white px-4 py-2 rounded-md cursor-pointer">Prev</button>
                                <button type="button"
                                    class="bg-slate-900 text-white px-4 py-2 rounded-md cursor-pointer"
                                    wire:click="generateVideo" :disabled="!$wire.content?.trim()"
                                    :class="{ 'opacity-50 cursor-not-allowed': !$wire.content?.trim() }">
                                    <span wire:loading.remove wire:target="generateVideo">Generate</span>
                                    <span wire:loading wire:target="generateVideo">Loading..</span>
                                </button>


                                <button type="button" @click="tab = 'video'"
                                    class="bg-slate-900 text-white px-4 py-2 rounded-md cursor-pointer">Response</button>
                            </div>

                        </div>
                        <textarea wire:model.live="content" id="" cols="30" rows="8"
                            class="border-2 p-3 rounded-lg mt-10  outline-none ring-0 mx-auto w-[80%] block"
                            placeholder="Add content here..."></textarea>
                    </div>
                    <div x-show="tab === 'video'" class="w-full">
                        <div class="flex justify-between items-center">
                            <div class="flex justify-end space-x-2">
                                <button type="button" @click="tab = 'script'"
                                    class="bg-slate-900 text-white px-4 py-2 rounded-md cursor-pointer">Prev</button>
                                <button type="button" @click="tab = 'video'"
                                    class="bg-slate-900 text-white px-4 py-2 rounded-md cursor-pointer">Response</button>

                            </div>
                        </div>
                        @if ($videoUrl)
                            <video width="80%" controls
                                class="mx-auto border-2 border-gray-300 bg-slate-50 rouned-md">
                                <source src="{{ $videoUrl }}" type="video/webm">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <p class="text-center text-gray-500">No video generated yet.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- <script>
            document.addEventListener('DOMContentLoaded', () => {
                const input = document.getElementById('activeStep_input_{{ $activeStep->id }}');
                const button = document.getElementById('submit_btn_{{ $activeStep->id }}');
                const originalValue = input.value; // Save the original value of the input

                input.addEventListener('input', () => {
                    if (input.value.trim() !== originalValue.trim()) {
                        button.classList.remove('hidden'); // Show the button
                    } else {
                        button.classList.add('hidden'); // Hide the button
                    }
                });
            });
        </script> --}}
    </div>


</div>
