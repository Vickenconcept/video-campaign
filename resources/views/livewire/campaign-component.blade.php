<div class="h-screen overflow-y-auto px-5 space-y-10" x-data="{ editStep: false }">
    {{-- Because she competes with no one, no one can compete with her. --}}
    {{-- {{ $campaign }} --}}
    <div>
        hello
        <div>
            <a href="{{ route('campaign.view', ['uuid' => $campaign->uuid]) }}">share</a>
            <a href="{{ route('campaign.view', ['uuid' => $campaign->uuid]) }}?preview">preview</a>
        </div>
        <div class="controls">
            <button class="cursor-pointer" onclick="zoomIn()">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6" />
                    </svg>

                </span>
            </button>
            <button class="cursor-pointer" onclick="zoomOut()">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM13.5 10.5h-6" />
                    </svg>

                </span>
            </button>
        </div>

    </div>

    <div class="flex gap-3 flex-wrap" id="zoomContainer" style="zoom: 0.9;">
        @php
            $lastPosition = $steps->max('position');
            $firstPosition = $steps->min('position');
        @endphp

        @forelse ($steps->sortBy('position') as $step)
            {{-- @forelse ($steps->sortBy('position') as $index => $step) --}}
            <div class="w-52 h-48 flex relative">
                <div @click="editStep = true" wire:click="setStep({{ $step->id }}, {{ $step->position }})"
                    class=" cursor-pointer rounded-l-lg border-2 border-slate-300 w-[75%]   bg-white hover:shadow-xl transition duration-500 ease-in-out overflow-hidden">
                    <div class="bg-slate-200 text-sm text-gray-800 font-bold py-1 px-2 truncate capitalize ">
                        {{ $step->name }}
                    </div>
                    <div class="h-full  grid grid-cols-2">
                        <div class="bg-slate-300 h-full"></div>
                        <div class="bg-white h-full py-4 px-2 space-y-3">
                            <div class=" bg-gray-800 p-3">
                            </div>
                            <div class=" bg-gray-500 p-3">
                            </div>
                            <div class=" bg-gray-300 p-3">
                            </div>
                        </div>

                    </div>
                </div>


                <div class="rounded-r-lg bg-gray-900 w-[15%] flex items-center justify-center ">
                    <div class="text-white bg-gray-900 text-center">
                        <button type="button" class="cursor-pointer" wire:click="addStep({{ $step->position }})">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                        @if ($steps->count() > 1)
                            @if ($step->position != $firstPosition)
                                <button ype="button" class="cursor-pointer"
                                    wire:click="deleteStep( {{ $step->id }},{{ $step->position }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>

                                </button>
                            @endif
                        @endif
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                </div>
                {{-- @if ($index < $steps->count() - 1) --}}
                @if ($step->position < $lastPosition)
                    <div class="w-[10%] flex items-center pl-2">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22.703" height="21.928">
                                <path
                                    d="M1.056 21.928c0-6.531 5.661-9.034 10.018-9.375V18.1L22.7 9.044 11.073 0v4.836a10.5 10.5 0 0 0-7.344 3.352C-.618 12.946-.008 21 .076 21.928z" />
                            </svg>
                        </span>
                    </div>
                @endif
                @if ($step->contact_detail)
                    <div class="absolute bottom-0 right-0">
                        <i class='bx bxs-contact text-gray-800 text-xl'></i>
                    </div>
                @endif
            </div>
        @empty
        @endforelse
    </div>






    <!-- edit step -->
    <div class="fixed items-center justify-center  flex top-0 left-0 mx-auto w-full h-full bg-slate-500/40 z-50 transition duration-1000 ease-in-out"
        x-show="editStep" style="display: none;">
        <div @click.away="editStep = false"
            class=" w-[90%] md:w-[100%] h-[100%] shadow-inner  overflow-auto  transition-all relative duration-700">
            <div class=" h-full ">

                <div class="grid grid-cols-3 h-full">
                    <div class="h-full lg:col-span-2 flex justify-center items-center">
                        <div class="h-[70%] w-[70%]  rounded-2xl overflow-hidden grid grid-cols-2"
                            wire:key="display-{{ now() }}">
                            <div class="h-full bg-slate-600">
                                @if ($activeStep)
                                    <video width="100%" controls
                                        class="mx-auto bg-slate-50 ">
                                        <source src="{{ $activeStep->video_url }}" type="video/webm">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                            </div>
                            {{-- <div class="h-full bg-slate-600" x-data="{ videoLoaded: false }" x-init="setTimeout(() => videoLoaded = true, 100)">
                                @if ($activeStep)
                                    <div x-show="!videoLoaded" class="text-white text-center p-4">Loading video...</div>

                                    <video x-show="videoLoaded" width="100%" controls class="mx-auto bg-slate-50">
                                        <source src="{{ $activeStep->video_url }}" type="video/webm">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                            </div> --}}

                            
                            <div class="h-full bg-white"></div>
                        </div>

                    </div>
                    <div class="h-full lg:col-span-1 bg-white p-6  overflow-y-auto ">
                        <div class="flex justify-end">
                            <button class="cursor-pointer" @click="editStep = false">
                                <i class="bx bx-x text-3xl font-bold hover:text-gray-600"></i>
                            </button>
                        </div>
                        <div class="mb-5">
                            <input type="text" wire:keydown.debounce.2000ms="saveStepName" class="form-control"
                                wire:model="activeName" placeholder="Enter step name (only visible to you)">
                        </div>

                        <div class="grid grid-cols-3 gap-1 py-3">
                            <div>
                                <button class="btn cursor-pointer" wire:click="goToTab('video')">video</button>
                            </div>
                            <div>
                                <button class="btn cursor-pointer" wire:click="goToTab('answer')">answer</button>
                            </div>
                            <div>
                                <button class="btn cursor-pointer" wire:click="goToTab('logic')">logic</button>
                            </div>
                        </div>
                        <section class=" h-[72%] overflow-y-auto">

                            <div class="space-y-5">
                                @if ($activeTab === 'video')
                                    <div class="">
                                        <livewire:video-setup :activeStep="$activeStep"
                                            wire:key="video-setup-{{ now() }}" />
                                    </div>
                                @endif
                                @if ($activeTab === 'answer')
                                    <div class="space-y-10">
                                        <div>
                                            <label for="answer_type" class="text-sm font-bold mb-1">Select answer
                                                type:</label>
                                            <select wire:model.live="answer_type" id="answer_type"
                                                wire:change="updateAnswerType()" class="form-control">
                                                <option value="open_ended" selected>Open Ended</option>
                                                <option value="ai_chat">AI Chat</option>
                                                <option value="multi_choice">Multiple Choice</option>
                                                <option value="button">Button</option>
                                                <option value="calender">Calendar</option>
                                                <option value="live_call">Live Call</option>
                                                <option value="NPS">NPS</option>
                                                <option value="file_upload">File Upload</option>
                                                <option value="payment">Payment</option>
                                            </select>
                                        </div>

                                        <div>
                                            @if ($answer_type == 'open_ended')
                                                <div>
                                                    <livewire:open-ended :activeStep="$activeStep"
                                                        wire:key="open-ended-{{ now() }}" />
                                                </div>
                                            @endif
                                            @if ($answer_type == 'multi_choice')
                                                <div>
                                                    <livewire:multi-choice :activeStep="$activeStep"
                                                        wire:key="multi-choice-{{ now() }}" />
                                                </div>
                                            @endif
                                            @if ($answer_type == 'button')
                                                <div>
                                                    <livewire:button-component :activeStep="$activeStep"
                                                        wire:key="button-{{ now() }}" />
                                                </div>
                                            @endif
                                            @if ($answer_type == 'calender')
                                                <div>
                                                    <livewire:calender-component :activeStep="$activeStep"
                                                        wire:key="calender-{{ now() }}" />
                                                </div>
                                            @endif
                                            @if ($answer_type == 'file_upload')
                                                <div>
                                                    <livewire:file-upload :activeStep="$activeStep"
                                                        wire:key="file-{{ now() }}" />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if ($activeTab === 'logic')
                                    <div class="">
                                        <livewire:logic-component :activeStep="$activeStep"
                                            wire:key="multi-choice-{{ now() }}" />
                                    </div>
                                @endif

                                <livewire:contact-form :activeStep="$activeStep ?? null" :activeTab="$activeTab"
                                    wire:key="open-ended-{{ now() }}" />
                            </div>
                        </section>
                    </div>

                </div>
            </div>
        </div>
    </div>




    <style>
        button:disabled {
            background-color: gray;
            cursor: not-allowed;
        }
    </style>

    <script>
        let zoomLevels = [0.5, 0.75, 1, 1.25, 1.5]; // Define zoom steps
        let currentIndex = 2; // Start at normal zoom (1.0)

        function updateButtons() {
            // document.getElementById('zoomInBtn').disabled = (currentIndex === zoomLevels.length - 1);
            // document.getElementById('zoomOutBtn').disabled = (currentIndex === 0);
        }

        function zoomIn() {
            if (currentIndex < zoomLevels.length - 1) {
                currentIndex++;
                document.getElementById('zoomContainer').style.zoom = zoomLevels[currentIndex];
                updateButtons();
            }
        }

        function zoomOut() {
            if (currentIndex > 0) {
                currentIndex--;
                document.getElementById('zoomContainer').style.zoom = zoomLevels[currentIndex];
                updateButtons();
            }
        }

        // Initialize button states
        updateButtons();




        document.addEventListener('DOMContentLoaded', function() {

            Livewire.on('notify', (data) => {
                if (data.status == 'success') {
                    Toastify({
                        text: `${data.msg}`,
                        duration: 3000,
                        backgroundColor: "linear-gradient(to right, #56ab2f, #a8e063)"
                    }).showToast();

                }
                if (data.status == 'error') {
                    Toastify({
                        text: `${data.msg}`,
                        duration: 3000,
                        backgroundColor: "linear-gradient(to right, #FF5F6D, #FFC371)"
                    }).showToast();
                }
            });
        });
    </script>


    @section('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var myWidget = cloudinary.createUploadWidget({
                    cloudName: "dp0bpzh9b",
                    uploadPreset: "video-campaign",
                    resourceType: "video",
                    clientAllowedFormats: ["mp4", "avi", "mov", "webm"],
                    maxFileSize: 500000000
                }, (error, result) => {
                    if (!error && result && result.event === "success") {
                        // console.log("Done! Here is the image info: ", result.info);
                        let response = result.info;

                        Livewire.dispatch('update-video', {url: response.secure_url })
                    }
                });

                function openWidget() {
                    myWidget.open();
                }

                function attachUploadListener() {
                    const uploadButton = document.getElementById("upload_widget");
                    if (uploadButton) {
                        // Remove any existing event listeners to prevent duplicates
                        uploadButton.removeEventListener("click", openWidget);
                        uploadButton.addEventListener("click", openWidget);
                    }
                }

                // Initial check if button exists
                attachUploadListener();

                // Observe the DOM for button appearing dynamically
                const observer = new MutationObserver(() => {
                    attachUploadListener();
                });

                observer.observe(document.body, {
                    childList: true,
                    subtree: true
                });
            });
        </script>







        <script>
            document.addEventListener('DOMContentLoaded', function() {

                window.addEventListener('play-audio', event => {
                    console.log("Full event object:", event.detail);
                    const audioData = Array.isArray(event.detail) ? event.detail[0] : event.detail;
                    if (!audioData?.url) {
                        console.error("Audio URL is missing!");
                        return;
                    }

                    if (window.currentAudio) {
                        window.currentAudio.pause();
                        window.currentAudio.currentTime = 0;
                    }
                    const audio = new Audio(audioData.url);
                    window.currentAudio = audio;
                    audio.play().catch(error => console.error("Audio playback error:", error));
                });

            })

            // window.addEventListener('play-audio', event => {
            //     console.log(event.detail.url);

            //     // Check if there's an existing audio instance before pausing
            //     if (window.currentAudio) {
            //         window.currentAudio.pause();
            //         window.currentAudio.currentTime = 0;
            //     }

            //     // Create and play new audio
            //     const audio = new Audio(event.detail.url);
            //     window.currentAudio = audio;

            //     audio.play().catch(error => console.error("Audio playback error:", error));
            // });
        </script>
    @endsection
</div>
