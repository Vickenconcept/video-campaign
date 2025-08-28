<div class="h-screen">

    <x-seo::meta />
  @seo([
        'title' => 'Videngager',
        'description' => 'Video funnel',
        'image' => asset('images/video-thumbnail.jpg'),
        'site_name' => config('app.name'),
        'favicon' => asset('favicon.ico'),
    ])




    @if(!$campaign)
        <div class="flex items-center justify-center h-screen bg-gray-50">
            <div class="text-center max-w-md mx-auto p-8">
                <div class="mb-6">
                    <i class='bx bx-error-circle text-6xl text-red-400'></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Campaign Not Found</h2>
                <p class="text-gray-600 mb-6">The requested campaign could not be loaded. Please check the URL or contact support.</p>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-sm text-red-800">
                        <i class='bx bx-info-circle mr-2'></i>
                        Campaign ID: {{ request()->route('uuid') ?? 'Unknown' }}
                    </p>
                </div>
            </div>
        </div>
    @elseif($steps && $steps->count() > 0)
        @php
            $lastPosition = $steps->max('id');
            $firstPosition = $steps->min('id');
        @endphp

        @foreach ($steps as $step)

        @php
            $nexts = json_decode($step->multi_choice_question, true);
            $previous = json_decode($step->previous, true) ?? [];
            $video_setting = json_decode($step->video_setting, true);
        @endphp


        @if ($step->id == $nextStep)
            @if ($step->id != optional($lastStep)->id)
                <div class="relative h-full w-full  overflow-hidden grid md:grid-cols-2">
                    
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

                        $absolutePositionClasses = [
                            'top-left' => 'top-0 left-0',
                            'top-center' => 'top-0 left-1/2 transform -translate-x-1/2',
                            'top-right' => 'top-0 right-0',
                            'center-left' => 'top-1/2 left-0 transform -translate-y-1/2',
                            'center' => 'top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2',
                            'center-right' => 'top-1/2 right-0 transform -translate-y-1/2',
                            'bottom-left' => 'bottom-0 left-0',
                            'bottom-center' => 'bottom-0 left-1/2 transform -translate-x-1/2',
                            'bottom-right' => 'bottom-0 right-0',
                        ];

                        $alignment = !$fit
                            ? $positionClasses[$video_setting['position']] ?? 'items-center justify-center'
                            : '';
                        
                        $absolutePosition = !$fit
                            ? $absolutePositionClasses[$video_setting['position']] ?? 'top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2'
                            : '';
                    @endphp

                    <div class="bg-red-500 h-full">
                   
                        @if (!empty($video_setting['overlay_text']))
                            <div
                                class="absolute w-full md:w-[50%] z-50 @if ($video_setting['overlay_bg'] ?? false) ) bg-black/30 @endif h-auto left-0 top-0 p-2 lg:p-5">
                                <p
                                    class="max-w-md mx-auto text-white text-center font-bold capitalize {{ $video_setting['text_size'] }}">
                                    {{ $video_setting['overlay_text'] ?? '' }}</p>
                            </div>
                        @endif
                        <div class="h-screen md:h-full w-full bg-slate-300 relative">

                            <div class="relative max-w-full max-h-full w-full h-full group" x-data="{ playing: false, shouldAutoplay: {{ $campaign->autoplay_video ? 'true' : 'false' }} }"
                                x-init="
                                    const yt = document.getElementById('yt-{{ $step->id }}');
                                    const vm = document.getElementById('vm-{{ $step->id }}');
                                    const playYT = () => { if (yt && yt.contentWindow) { yt.contentWindow.postMessage(JSON.stringify({event:'command',func:'playVideo',args:[]}), '*'); } };
                                    const pauseYT = () => { if (yt && yt.contentWindow) { yt.contentWindow.postMessage(JSON.stringify({event:'command',func:'pauseVideo',args:[]}), '*'); } };
                                    const playVM = () => { if (vm && vm.contentWindow) { vm.contentWindow.postMessage({ method: 'play' }, '*'); } };
                                    const pauseVM = () => { if (vm && vm.contentWindow) { vm.contentWindow.postMessage({ method: 'pause' }, '*'); } };
                                    const controlByVisibility = () => {
                                        const active = shouldAutoplay && document.visibilityState === 'visible' && document.hasFocus();
                                        if ($refs.player) {
                                            if (active) { 
                                                try { 
                                                    $refs.player.play().catch(e => console.log('Autoplay prevented:', e.message)); 
                                                } catch (e) {} 
                                            } else { 
                                                $refs.player.pause(); 
                                            }
                                        } else {
                                            if (active) { 
                                                try { playYT(); playVM(); } catch (e) {} 
                                            } else { 
                                                pauseYT(); pauseVM(); 
                                            }
                                        }
                                    };
                                    const tryStartPlayback = () => {
                                        const active = shouldAutoplay && document.visibilityState === 'visible' && document.hasFocus();
                                        if (!active) return;
                                        if ($refs.player) {
                                            try { 
                                                $refs.player.play().catch(e => console.log('Autoplay prevented:', e.message)); 
                                            } catch (e) {} 
                                        } else {
                                            try { playYT(); playVM(); } catch (e) {} 
                                        }
                                    };
                                    if ($refs.player) {
                                        $refs.player.addEventListener('play', () => playing = true);
                                        $refs.player.addEventListener('pause', () => playing = false);
                                        $refs.player.addEventListener('loadedmetadata', tryStartPlayback);
                                        $refs.player.addEventListener('canplay', tryStartPlayback);
                                    }
                                    if (yt) { yt.addEventListener('load', tryStartPlayback); }
                                    if (vm) { vm.addEventListener('load', tryStartPlayback); }
                                    document.addEventListener('visibilitychange', controlByVisibility);
                                    window.addEventListener('focus', controlByVisibility);
                                    window.addEventListener('blur', controlByVisibility);
                                    $nextTick(() => {
                                        // Only try autoplay if user has interacted with the page
                                        if (document.visibilityState === 'visible') {
                                            setTimeout(controlByVisibility, 200);
                                            // Remove aggressive autoplay attempts to prevent errors
                                            // setTimeout(tryStartPlayback, 200);
                                            // setTimeout(tryStartPlayback, 800);
                                        }
                                    });
                                ">

                                @if ($step->video_url)
                                    @php $autoplay = (bool) ($campaign->autoplay_video ?? false); @endphp
                                    @php
                                        $isExternalVideo = str_contains($step->video_url, 'youtube.com') || str_contains($step->video_url, 'youtu.be') || str_contains($step->video_url, 'vimeo.com');
                                    @endphp
                                    
                                    @if($isExternalVideo)
                                        <!-- External Video (YouTube/Vimeo) -->
                                        @if(str_contains($step->video_url, 'youtube.com/watch?v='))
                                            @php
                                                $videoId = null;
                                                if (str_contains($step->video_url, 'youtube.com/watch?v=')) {
                                                    $videoId = substr($step->video_url, strpos($step->video_url, 'v=') + 2);
                                                    $videoId = strtok($videoId, '&');
                                                } elseif (str_contains($step->video_url, 'youtu.be/')) {
                                                    $videoId = substr($step->video_url, strrpos($step->video_url, '/') + 1);
                                                    $videoId = strtok($videoId, '?');
                                                }
                                            @endphp
                                            @if($videoId)
                                                @if($fit)
                                                    <!-- Fit mode: Center the video -->
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <iframe id="yt-{{ $step->id }}"
                                                            width="100%" 
                                                            height="100%" 
                                                            src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&autoplay={{ $autoplay ? 1 : 0 }}&controls=1&mute=0&enablejsapi=1" 
                                                            frameborder="0" 
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                            allowfullscreen
                                                            class="w-full h-full max-w-full max-h-full object-contain">
                                                        </iframe>
                                                    </div>
                                                @else
                                                    <!-- Position mode: Full width like local videos -->
                                                    <iframe id="yt-{{ $step->id }}"
                                                        width="100%" 
                                                        height="100%" 
                                                        src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&autoplay={{ $autoplay ? 1 : 0 }}&controls=1&mute=0&enablejsapi=1" 
                                                        frameborder="0" 
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                        allowfullscreen
                                                        class="absolute w-full h-full {{ $absolutePosition }}">
                                                    </iframe>
                                                @endif
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <p class="text-gray-500">Invalid YouTube URL</p>
                                                </div>
                                            @endif
                                        @elseif(str_contains($step->video_url, 'vimeo.com'))
                                            @php
                                                $videoId = substr($step->video_url, strrpos($step->video_url, '/') + 1);
                                                $videoId = strtok($videoId, '?');
                                            @endphp
                                            @if($videoId)
                                                @if($fit)
                                                    <!-- Fit mode: Center the video -->
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <iframe id="vm-{{ $step->id }}"
                                                            width="100%" 
                                                            height="100%" 
                                                            src="https://player.vimeo.com/video/{{ $videoId }}?h=hash&title=0&byline=0&portrait=0&autoplay={{ $autoplay ? 1 : 0 }}&controls=1&muted=0" 
                                                            frameborder="0" 
                                                            allow="autoplay; fullscreen; picture-in-picture" 
                                                            allowfullscreen
                                                            class="w-full h-full max-w-full max-h-full object-contain">
                                                        </iframe>
                                                    </div>
                                                @else
                                                    <!-- Position mode: Full width like local videos -->
                                                    <iframe id="vm-{{ $step->id }}"
                                                        width="100%" 
                                                        height="100%" 
                                                        src="https://player.vimeo.com/video/{{ $videoId }}?h=hash&title=0&portrait=0&autoplay={{ $autoplay ? 1 : 0 }}&controls=1&muted=0" 
                                                        frameborder="0" 
                                                        allow="autoplay; fullscreen; picture-in-picture" 
                                                        allowfullscreen
                                                        class="absolute w-full h-full {{ $absolutePosition }}">
                                                    </iframe>
                                                @endif
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <p class="text-gray-500">Invalid Vimeo URL</p>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        <!-- Local Video -->
                                        @if($fit)
                                            <video x-ref="player" @if($autoplay) autoplay playsinline @endif
                                                class="mx-auto bg-slate-50/10 max-w-full max-h-full w-full object-contain"
                                                :controls="false">
                                                <source src="{{ $step->video_url }}" type="video/webm">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <video x-ref="player" @if($autoplay) autoplay playsinline @endif
                                                class="absolute w-full h-full object-contain {{ $absolutePosition }}"
                                                :controls="false">
                                                <source src="{{ $step->video_url }}" type="video/webm">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif

                                        <!-- Custom Play/Pause button shown only on hover -->
                                        <div class="absolute top-0 left-0 h-full w-full flex items-center justify-center">
                                            <button
                                                @click="$refs.player.paused ? $refs.player.play() : $refs.player.pause()"
                                                class=" inset-0 cursor-pointer flex items-center justify-center text-white bg-black/50 rounded-full transition duration-300 opacity-100 md:opacity-0 md:group-hover:opacity-100">
                                                <svg x-show="!playing" style="display: none;" class="size-20" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M14.752 11.168l-5.197-3.028A1 1 0 008 9.028v5.944a1 1 0 001.555.832l5.197-3.028a1 1 0 000-1.664z" />
                                            </svg>

                                            <svg x-show="playing" style="display: none;" class="size-20" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M10 9v6m4-6v6" />
                                            </svg>
                                        </button>
                                    </div>
                                    @endif
                                @endif
                                {{-- @if (!empty($video_setting['overlay_text']))
                                <div
                                    class="absolute @if ($video_setting['overlay_bg'] ?? false) ) bg-black/30 @endif h-auto w-full left-0 top-0 p-5">
                                    <p
                                        class="max-w-md mx-auto text-white text-center font-bold capitalize {{ $video_setting['text_size'] }}">
                                        {{ $video_setting['overlay_text'] ?? '' }}</p>
                                </div>
                            @endif --}}
                            </div>
                        </div>
                    </div>

                    <div
                        class="absolute w-full left-0 bottom-0 md:relative md:h-full bg-slate-50/80 md:bg-white flex justify-center items-center overflow-y-auto px-3 pb-3 pt-5  md:pt-0 md:px-0 md:pb-10">
                        @if ($preview)
                            <div class="absolute h-auto w-full left-0 top-0 p-1 bg-indigo-600">
                                <p class="max-w-md mx-auto text-white text-center font-medium text-sm">
                                    You're in preview mode, answers won't be submitted
                                </p>
                            </div>
                        @endif
                        <div class="">
                            <div class="absolute hidden lg:flex -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-blue-400/20 to-indigo-400/20 rounded-full blur-3xl"></div>
                            <div class="absolute hidden lg:flex -bottom-40 -left-40 w-80 h-80 bg-gradient-to-r from-purple-400/20 to-pink-400/20 rounded-full blur-3xl"></div>
                        </div>
                        <div
                            class="h-full md:h-[80%] w-full md:w-[80%] md:border rounded-md flex justify-center items-center overflow-y-auto ">
                            <div class="w-full md:w-[80%] ">
                                {{-- {{ $step->name }} --}}
                                <div class="w-full">
                                    @if ($step->contact_detail && $step->id === $contactDetailShownStepId)
                                        @php
                                            $form = json_decode($step->form, true);
                                        @endphp

                                        <div class="mb-10 text-gray-800">
                                            <h3 class="font-bold text-xl text-center">Fill out the form below </h3>
                                        </div>
                                        <div class="space-y-4">
                                            @foreach ($activeForm as $field)
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
                                                                    wire:model.live="{{ $field['name'] }}"
                                                                    @if ($field['required']) required @endif>
                                                            @break

                                                            @case('checkbox')
                                                                <div class="flex items-center">
                                                                    <input type="checkbox" name="{{ $field['name'] }}"
                                                                        id="{{ $field['name'] }}"
                                                                        wire:model.live="{{ $field['name'] }}"
                                                                        class="h-4 w-4 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                                                    <label for="{{ $field['name'] }}"
                                                                        class="ml-2 text-gray-700">
                                                                        {{ $field['label'] }}
                                                                    </label>
                                                                </div>
                                                            @break

                                                            @default
                                                                <input type="text" name="{{ $field['name'] }}"
                                                                    id="{{ $field['name'] }}" class="form-control"
                                                                    placeholder="{{ $field['label'] }}"
                                                                    wire:model.live="{{ $field['name'] }}">
                                                        @endswitch
                                                    </div>
                                                @endif
                                            @endforeach

                                            <div class="flex space-x-3">
                                                @if ($nextStep !== $firstPosition)
                                                    @foreach ($previous as $index => $prev)
                                                        <button class="btn cursor-pointer"
                                                            wire:click="goToPrevious({{ $step->id }},'{{ $index }}')">
                                                            Back
                                                        </button>
                                                    @endforeach
                                                @endif


                                                @foreach ($nexts as $index => $next)
                                                    @if ($loop->first)
                                                        <button
                                                            class="btn  {{ !$this->canContinue ? 'cursor-not-allowed opacity-50' : 'cursor-pointer' }}"
                                                            @if (!$this->canContinue) disabled @endif
                                                            wire:click="goToNext({{ $step->id }},'{{ $index }}')">
                                                            Next
                                                        </button>
                                                    @endif
                                                @endforeach

                                            </div>
                                        </div>
                                    @else
                                        @switch($step->answer_type)
                                            @case('open_ended')
                                                @include('components.response.open-ended')
                                            @break

                                            @case('ai_chat')
                                                <div class="{{ $preview ? 'select-none cursor-not-allowed blur-xs' : '' }}">
                                                    <livewire:ai-chat :preview="$preview" />
                                                </div>
                                            @break

                                            @case('multi_choice')
                                                @include('components.response.multi-choice')
                                            @break

                                            @case('button')
                                                @include('components.response.button')
                                            @break

                                            @case('calender')
                                                @include('components.response.calender')
                                            @break

                                            @case('payment')
                                                @include('components.response.payment')
                                            @break

                                            @case('file_upload')
                                                @include('components.response.file_upload')
                                            @break

                                            @case('NPS')
                                                @include('components.response.NPS')
                                            @break

                                            @case('timer')
                                                @include('components.response.timer')
                                            @break

                                            @case('map')
                                                @include('components.response.map')
                                            @break
                                        @endswitch
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="relative h-full w-full  overflow-hidden">
                    <div class="h-full w-full bg-gray-500">
                        <img src="{{ $step->last_cover_image ? $step->last_cover_image : 'https://placehold.co/600x400?font=roboto&text=Thank\nYou' }}"
                            alt="" class="object-cover object-center w-full h-full">
                    </div>

                </div>
            @endif

        @endif

        @endforeach
    @else
        <div class="flex items-center justify-center h-screen bg-gray-50">
            <div class="text-center max-w-md mx-auto p-8">
                <div class="mb-6">
                    <i class='bx bx-video text-6xl text-gray-400'></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Campaign Not Ready</h2>
                <p class="text-gray-600 mb-6">This campaign doesn't have any steps configured yet. Please contact the campaign owner to set up the video funnel.</p>
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <p class="text-sm text-orange-800">
                        <i class='bx bx-info-circle mr-2'></i>
                        Campaign ID: {{ $campaign->uuid ?? 'Unknown' }}
                    </p>
                </div>
            </div>
        </div>
    @endif


    <!-- Paypal -->
    <script>
        let clientID = '';
        let currency = '';
        let amount = '';

        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('paypalKeysUpdated', (data) => {
                clientID = data[0].client_id;
                currency = data[0].currency;
                amount = data[0].amount;
                const script = document.createElement('script');
                script.src = `https://www.paypal.com/sdk/js?client-id=${clientID}&currency=${currency}`;
                script.onload = () => {
                    console.log('PayPal SDK loaded');

                    paypal.Buttons({

                        createOrder: function(data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: amount,
                                        // currency_code: currency
                                    }
                                }]
                            });
                        },
                        onApprove: function(data, actions) {
                            return actions.order.capture().then(function(details) {
                                // Handle successful payment
                                console.log('Payment successful:', details);
                            });
                        }
                        // ...
                    }).render('#paypal-button-container');
                };
                document.head.appendChild(script);

            });
        });
    </script>





    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('responseRecorder', () => {
                return {
                    openResponse: null,
                    mediaRecorder: null,
                    audioChunks: [],
                    videoStream: null,
                    shouldContinue: false,
                    textResponse: @entangle('textResponse'),
                    countdown: 60,
                    countdownInterval: null,

                startAudioRecording() {
                    console.log('Audio recording started');

                    this.countdown = 60;

                    // Start countdown
                    this.countdownInterval = setInterval(() => {
                        if (this.countdown > 0) {
                            this.countdown--;
                        } else {
                            clearInterval(this.countdownInterval);
                            this.stopAudioRecording();
                        }
                    }, 1000);

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
                        // Remove the setTimeout since countdown will handle stopping
                        // setTimeout(() => this.stopAudioRecording(), 60000);
                    });
                },




                stopAudioRecording() {
                    if (this.mediaRecorder && this.mediaRecorder.state !== 'inactive') {
                        this.mediaRecorder.stop();
                    }

                    if (this.mediaRecorder.stream) {
                        this.mediaRecorder.stream.getTracks().forEach(track => track.stop());
                    }

                    clearInterval(this.countdownInterval);

                    setTimeout(() => {
                        this.shouldContinue = true;
                    }, 2000);
                },


                startVideoRecording() {

                    this.countdown = 60;

                    // Start countdown
                    this.countdownInterval = setInterval(() => {
                        if (this.countdown > 0) {
                            this.countdown--;
                        } else {
                            clearInterval(this.countdownInterval);
                            this.stopVideoRecording();
                        }
                    }, 1000);

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
                            console.log('Video recording stopped');

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
                        // Remove the setTimeout since countdown will handle stopping
                        // setTimeout(() => this.stopVideoRecording(), 60000);
                    });
                },


                stopVideoRecording() {
                    if (this.mediaRecorder && this.mediaRecorder.state !== 'inactive') {
                        this.mediaRecorder.stop();
                    }

                    // Stop the camera stream completely
                    if (this.mediaRecorder.stream) {
                        this.mediaRecorder.stream.getTracks().forEach(track => track.stop());
                    }

                    clearInterval(this.countdownInterval);

                    setTimeout(() => {
                        this.shouldContinue = true;
                    }, 2000);
                }

            }
            });
        });
    </script>



    {{-- timer --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('timerCountdown', (params) => {
                return timerCountdown(params);
            });
        });

        function timerCountdown({
            start,
            end
        }) {
            return {
                days: 0,
                hours: 0,
                minutes: 0,
                seconds: 0,
                ctaDisabled: false,
                interval: null,
                startCountdown() {
                    let now = new Date();
                    let parsedStart = start ? new Date(start) : null;
                    let parsedEnd = end ? new Date(end) : null;
                    let target;

                    // Debug logging
                    console.log('Timer start:', start, 'parsed:', parsedStart);
                    console.log('Timer end:', end, 'parsed:', parsedEnd);
                    console.log('Current time:', now);

                    if (parsedStart && now < parsedStart) {
                        // Start is in the future
                        target = parsedStart;
                        console.log('Using start time as target:', target);
                    } else if (parsedEnd && now < parsedEnd) {
                        // Start is in the past, but end is in the future
                        target = parsedEnd;
                        console.log('Using end time as target:', target);
                    } else if (parsedStart && parsedEnd) {
                        // Both times provided, use the one that's further in the future
                        let startDiff = parsedStart - now;
                        let endDiff = parsedEnd - now;
                        if (startDiff > 0 || endDiff > 0) {
                            target = startDiff > endDiff ? parsedStart : parsedEnd;
                            console.log('Using future time as target:', target);
                        } else {
                            // Both are in the past, set a default future time (24 hours from now)
                            target = new Date(now.getTime() + (24 * 60 * 60 * 1000));
                            console.log('Both times in past, using default 24h future:', target);
                        }
                    } else {
                        // No valid times provided, set a default future time (24 hours from now)
                        target = new Date(now.getTime() + (24 * 60 * 60 * 1000));
                        console.log('No valid times, using default 24h future:', target);
                    }

                    this.updateCountdown(target);
                    this.interval = setInterval(() => {
                        this.updateCountdown(target);
                    }, 1000);
                },
                updateCountdown(target) {
                    const now = new Date();
                    let diff = target - now;
                    if (diff < 0) diff = 0;
                    this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    this.hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
                    this.minutes = Math.floor((diff / (1000 * 60)) % 60);
                    this.seconds = Math.floor((diff / 1000) % 60);
                    // Button is only disabled AFTER countdown ends
                    this.ctaDisabled = diff === 0;
                    if (diff === 0 && this.interval) {
                        clearInterval(this.interval);
                    }
                }
            }
        }
    </script>


    <script src="https://upload-widget.cloudinary.com/latest/global/all.js" type="text/javascript"></script>

    <script>
        // Initialize Cloudinary upload widget for file uploads in show-campaign
        let fileUploadWidget;

        function initializeFileUploadWidget() {
            const uploadButton = document.getElementById('upload_widget');
            if (typeof cloudinary === 'undefined' || !uploadButton) {
                return;
            }

            if (!fileUploadWidget) {
                fileUploadWidget = cloudinary.createUploadWidget({
                    cloudName: "dp0bpzh9b",
                    uploadPreset: "video-campaign",
                    resourceType: "raw",
                    // Intentionally omit clientAllowedFormats here so preset controls allowed formats
                    maxFileSize: 500000000
                }, (error, result) => {
                    if (!error && result && result.event === "success") {
                        const response = result.info;

                        Livewire.dispatch('update-file', { url: response.secure_url });

                        Toastify({
                            text: `Uploaded!, close and continue`,
                            position: "center",
                            duration: 3000,
                            backgroundColor: "linear-gradient(to right, #56ab2f, #a8e063)"
                        }).showToast();

                        fileUploadWidget.close();
                    }
                });
            }

            function openWidget(e) {
                if (e) e.preventDefault();
                fileUploadWidget.open();
            }

            // Ensure single listener
            uploadButton.removeEventListener('click', openWidget);
            uploadButton.addEventListener('click', openWidget);
        }

        // DOM ready
        document.addEventListener('DOMContentLoaded', initializeFileUploadWidget);

        // When Livewire navigates
        document.addEventListener('livewire:navigated', () => {
            setTimeout(initializeFileUploadWidget, 100);
        });

        // Fallback
        setTimeout(initializeFileUploadWidget, 1000);
    </script>


    <script>
        const userLang = @json($selectedLang);
    </script>

</div>
