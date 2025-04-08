<div class="h-screen">
    {{-- @php
        $lastPosition = $steps->max('position');
        $firstPosition = $steps->min('position');
    @endphp --}}

    {{-- 
    
    @if ($step->answer_type == 'button')
        <p>button</p>
    @endif
    @if ($step->answer_type == 'calender')
        <p>calender</p>
    @endif

    @if ($step->answer_type == 'live_call')
        <p>live_call</p>
    @endif

    @if ($step->answer_type == 'NPS')
        <p>NPS</p>
    @endif

    @if ($step->answer_type == 'file_upload')
        <p>file_upload</p>
    @endif

    @if ($step->answer_type == 'payment')
        <p>payment</p>
    @endif --}}


    @php
        $lastPosition = $steps->max('position');
        $firstPosition = $steps->min('position');

    @endphp
    @foreach ($steps as $step)
        @php
            $nexts = json_decode($step->multi_choice_question, true);
            $previous = json_decode($step->previous, true);
            $video_setting = json_decode($step->video_setting, true);
        @endphp


        @if ($step->id == $nextStep)
            <div class="h-full w-full  overflow-hidden grid grid-cols-2" wire:transition>
                @php
                    $fit = $video_setting['fit'] ?? false;

                    $positionClasses = [
                        'top-left' => 'items-start justify-start',
                        'top-center' => 'items-start justify-center',
                        'top-right' => 'items-start justify-end',
                        'center-left' => 'items-center justify-start',
                        'center' => 'items-center justify-center',
                        'center-right' => 'items-center justify-end',
                        'bottom-left' => 'items-end justify-start',
                        'bottom-center' => 'items-end justify-center',
                        'bottom-right' => 'items-end justify-end',
                    ];

                    $alignment = !$fit
                        ? $positionClasses[$video_setting['position']] ?? 'items-center justify-center'
                        : '';
                @endphp

                <div class="h-full w-full bg-slate-300 flex {{ $alignment }}">
                    <div class="relative max-w-full max-h-full">
                        @if ($step->video_url)
                            <video controls class="mx-auto bg-slate-50/10 max-w-full max-h-full object-contain">
                                <source src="{{ $step->video_url }}" type="video/webm">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                        @if (!empty($video_setting['overlay_text']))
                            <div
                                class="absolute @if ($video_setting['overlay_bg'] ?? false) ) bg-black/30 @endif h-auto w-full left-0 top-0 p-5">
                                <p
                                    class="max-w-md mx-auto text-white text-center font-bold capitalize {{ $video_setting['text_size'] }}">
                                    {{ $video_setting['overlay_text'] ?? '' }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="relative h-full bg-white flex justify-center items-center">
                    @if ($preview)
                        <div class="absolute h-auto w-full left-0 top-0 p-1 bg-gray-800">
                            <p class="max-w-md mx-auto text-white text-center font-medium text-sm">
                                You're in preview mode, answers won't be submitted
                            </p>
                        </div>
                    @endif
                    <div class="h-[80%] w-[80%] border rounded-md flex justify-center items-center">
                        {{-- {{ $step->name }} --}}
                        <div class="w-[80%] ">
                            {{ $step->name }}

                            <div class="w-full">
                                @if ($step->contact_detail && $step->id === $contactDetailShownStepId)
                                    @php
                                        $form = json_decode($step->form, true);
                                    @endphp
                                    <div class="space-y-4">
                                        @foreach ($form as $field)
                                            @if ($field['active'])
                                                <div class="space-y-2">
                                                    <label for="{{ $field['name'] }}"
                                                        class="block font-semibold text-gray-700 capitalize">
                                                        {{ $field['label'] }}
                                                        @if ($field['required'])
                                                            <span class="text-red-500">*</span>
                                                        @endif
                                                    </label>

                                                    @switch($field['type'])
                                                        @case('text')
                                                        @case('email')

                                                        @case('tel')
                                                            <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                                                id="{{ $field['name'] }}" class="form-control"
                                                                placeholder="{{ $field['label'] }}"
                                                                @if ($field['required']) required @endif>
                                                        @break

                                                        @case('checkbox')
                                                            <div class="flex items-center">
                                                                <input type="checkbox" name="{{ $field['name'] }}"
                                                                    id="{{ $field['name'] }}"
                                                                    class="h-4 w-4 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                                                <label for="{{ $field['name'] }}" class="ml-2 text-gray-700">
                                                                    {{ $field['label'] }}
                                                                </label>
                                                            </div>
                                                        @break

                                                        @default
                                                            <input type="text" name="{{ $field['name'] }}"
                                                                id="{{ $field['name'] }}" class="form-control"
                                                                placeholder="{{ $field['label'] }}">
                                                    @endswitch
                                                </div>
                                            @endif
                                        @endforeach

                                        <div class="flex space-x-3">
                                            @foreach ($previous as $index => $prev)
                                                <button class="btn cursor-pointer"
                                                    wire:click="goToPrevious({{ $step->id }},'{{ $index }}')">
                                                    Back
                                                </button>
                                            @endforeach
                                            @foreach ($nexts as $index => $next)
                                                @if ($loop->first)
                                                    <button class="btn cursor-pointer"
                                                        wire:click="goToNext({{ $step->id }},'{{ $index }}')">
                                                        {{-- {{ $index }} --}}
                                                        Continue
                                                    </button>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    @if ($step->answer_type == 'open_ended')
                                        @include('components.response.open-ended')
                                    @endif

                                    @if ($step->answer_type == 'ai_chat')
                                        <p>ai_chat</p>
                                    @endif

                                    @if ($step->answer_type == 'multi_choice')
                                        @include('components.response.multi-choice')
                                    @endif
                                @endif
                            </div>


                            {{-- @foreach ($previous as $index => $prev)
                                <button class="btn"
                                    wire:click="goToPrevious({{ $step->id }},'{{ $index }}')">
                                    Back
                                </button>
                            @endforeach --}}


                            {{-- @if ($lastPosition != $step->id)
                                @foreach ($nexts as $index => $next)
                                    <button class="btn"
                                        wire:click="goToNext({{ $step->id }},'{{ $index }}')">
                                        {{ $index }}
                                    </button>
                                @endforeach
                            @else
                                <button class="btn">
                                    Finish
                                </button>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <p>{{ $nextStep }}</p>




    <script>
        function responseRecorder() {
            return {
                openResponse: null,
                mediaRecorder: null,
                audioChunks: [],
                videoStream: null,
                shouldContinue: false,
                textResponse: @entangle('textResponse'),



                startAudioRecording() {
                    console.log('Audio recording started');
                    navigator.mediaDevices.getUserMedia({
                        audio: true
                    }).then(stream => {
                        this.mediaRecorder = new MediaRecorder(stream);
                        this.audioChunks = [];

                        this.mediaRecorder.ondataavailable = e => {
                            console.log('Audio data available:', e.data);
                            this.audioChunks.push(e.data);
                        };

                        this.mediaRecorder.onstop = () => {
                            console.log('Audio recording stopped');
                            const audioBlob = new Blob(this.audioChunks, {
                                type: 'audio/webm'
                            });
                            const audioUrl = URL.createObjectURL(audioBlob);
                            this.$refs.audioPlayer.src = audioUrl;

                            this.$refs.videoPlayer.srcObject = null;
                            this.$refs.videoPlayer.src = audioUrl; // You can use this URL to preview audio

                            const file = new File([audioBlob], `audio_${Date.now()}.webm`, {
                                type: 'audio/webm'
                            });

                            // Put it in the hidden file input
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            this.$refs.audioUpload = dataTransfer
                                .files; 

                            const audioFile = dataTransfer.files[0];
                            console.log(audioFile);

                            @this.upload('audioResponse', audioFile, () => {
                                @this.call('saveAudio');
                            }, () => {
                                alert('Something went wrong while uploading your audio');
                            });


                        };


                        this.mediaRecorder.start();
                        setTimeout(() => this.stopAudioRecording(),
                            60000);
                    });
                },


                // startAudioRecording() {
                //     navigator.mediaDevices.getUserMedia({
                //         audio: true, // Only request audio
                //         video: false // Don't request video
                //     }).then(stream => {
                //         // Set up the audio stream
                //         this.audioStream = stream;

                //         // Create the MediaRecorder for audio
                //         this.mediaRecorder = new MediaRecorder(stream);
                //         const chunks = [];

                //         // Collect data as it's available
                //         this.mediaRecorder.ondataavailable = e => chunks.push(e.data);

                //         // When recording stops, handle the resulting audio data
                //         this.mediaRecorder.onstop = () => {
                //             console.log('Audio recording stopped');

                //             const audioBlob = new Blob(chunks, {
                //                 type: 'audio/webm'
                //             });
                //             const audioUrl = URL.createObjectURL(audioBlob);

                //             // Reset the video player source
                //             this.$refs.videoPlayer.srcObject = null;
                //             this.$refs.videoPlayer.src = audioUrl; // You can use this URL to preview audio

                //             // Convert the audio Blob to a File
                //             const file = new File([audioBlob], `audio_${Date.now()}.webm`, {
                //                 type: 'audio/webm'
                //             });

                //             // Put it in the hidden file input
                //             const dataTransfer = new DataTransfer();
                //             dataTransfer.items.add(file);
                //             this.$refs.audioUpload.files = dataTransfer
                //             .files; // Assuming you have a file input for audio

                //             // Now we can upload the audio file using Livewire
                //             const audioFile = dataTransfer.files[0];

                //             // Upload to the backend using Livewire
                //             @this.upload('audioResponse', audioFile, () => {
                //                 @this.call('saveAudio');
                //             }, () => {
                //                 alert('Something went wrong while uploading your audio');
                //             });
                //         };

                //         // Start recording audio
                //         this.mediaRecorder.start();

                //         // Optionally, stop the recording after a certain amount of time
                //         setTimeout(() => this.stopAudioRecording(), 60000); // 1 minute for example
                //     }).catch(error => {
                //         console.error('Error accessing audio device:', error);
                //     });
                // },




                stopAudioRecording() {
                    this.mediaRecorder.stop();
                    this.shouldContinue = true;
                },

                startVideoRecording() {
                    navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: true
                    }).then(stream => {
                        this.$refs.videoPlayer.srcObject = stream;
                        this.videoStream = stream;

                        this.mediaRecorder = new MediaRecorder(stream);
                        const chunks = [];

                        this.mediaRecorder.ondataavailable = e => chunks.push(e.data);

                        this.mediaRecorder.onstop = () => {
                            console.log('Audio recording stopped');

                            const videoBlob = new Blob(chunks, {
                                type: 'video/webm'
                            });
                            const videoUrl = URL.createObjectURL(videoBlob);
                            this.$refs.videoPlayer.srcObject = null;
                            this.$refs.videoPlayer.src = videoUrl;

                            // Convert Blob to File
                            const file = new File([videoBlob], `video_${Date.now()}.webm`, {
                                type: 'video/webm'
                            });

                            // Put it in the hidden file input
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            this.$refs.videoUpload.files = dataTransfer.files;

                            // Livewire.dispatch('video-recorded', { file: file  });
                            const videoFile = dataTransfer.files[0];

                            @this.upload('videoResponse', videoFile, () => {
                                @this.call('saveVideo');
                            }, () => {
                                alert('Something went wrong while uploading your video');
                            });


                        };

                        this.mediaRecorder.start();
                        setTimeout(() => this.stopVideoRecording(), 60000);
                    });
                },




                stopVideoRecording() {
                    this.mediaRecorder.stop();
                    this.shouldContinue = true;
                    // Stop all tracks in the stream (this will turn off the camera)

                    // if (this.mediaStream) {
                    //     const tracks = this.mediaStream.getTracks();
                    //     tracks.forEach(track => track.stop());
                    // }

                    // // Optionally, reset the mediaRecorder and mediaStream if needed
                    // this.mediaRecorder = null;
                    // this.mediaStream = null;

                    // // You can also hide the video element or camera feed if it's still showing
                    // const videoElement = document.querySelector('video');
                    // if (videoElement) {
                    //     videoElement.srcObject = null; // Stops the video feed from showing
                    // }
                }
            }
        }
    </script>

</div>
