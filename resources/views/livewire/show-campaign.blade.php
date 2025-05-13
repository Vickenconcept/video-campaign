<div class="h-screen">
    {{-- @php
        $lastPosition = $steps->max('position');
        $firstPosition = $steps->min('position');
    @endphp --}}

    {{-- 
    
    @if ($step->answer_type == 'live_call')
        <p>live_call</p>
    @endif

    @if ($step->answer_type == 'NPS')
        <p>NPS</p>
    @endif

  --}}

    <x-seo::meta />
    @seo([
        'title' => 'Campain Video ask',
        'description' => 'Campain',
        'image' => asset('images/video-thumbnail.jpg'),
        'site_name' => config('app.name'),
        'favicon' => asset('images/fav-image.png'),
    ])




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

                        $alignment = !$fit
                            ? $positionClasses[$video_setting['position']] ?? 'items-center justify-center'
                            : '';
                    @endphp

                    <div class="h-screen md:h-full w-full bg-slate-300 flex {{ $alignment }}">
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

                    <div
                        class="absolute w-full left-0 bottom-0 md:relative md:h-full bg-black/30 md:bg-white flex justify-center items-center overflow-y-auto pb-10">
                        @if ($preview)
                            <div class="absolute h-auto w-full left-0 top-0 p-1 bg-gray-800">
                                <p class="max-w-md mx-auto text-white text-center font-medium text-sm">
                                    You're in preview mode, answers won't be submitted
                                </p>
                            </div>
                        @endif
                        <div
                            class="h-[80%] w-[80%] md:border rounded-md flex justify-center items-center overflow-y-auto ">
                            <div class="w-[80%] ">
                                {{-- {{ $step->name }} --}}
                                <div class="w-full">
                                    @if ($step->contact_detail && $step->id === $contactDetailShownStepId)
                                        @php
                                            $form = json_decode($step->form, true);
                                        @endphp
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
                                        @if ($step->answer_type == 'open_ended')
                                            @include('components.response.open-ended')
                                        @endif

                                        @if ($step->answer_type == 'ai_chat')
                                            <div class="{{ $preview ? 'select-none cursor-not-allowed blur-xs' : '' }}">
                                                <livewire:ai-chat :preview="$preview" />
                                            </div>
                                        @endif

                                        @if ($step->answer_type == 'multi_choice')
                                            @include('components.response.multi-choice')
                                        @endif
                                        @if ($step->answer_type == 'button')
                                            @include('components.response.button')
                                        @endif
                                        @if ($step->answer_type == 'calender')
                                            @include('components.response.calender')
                                        @endif
                                        @if ($step->answer_type == 'payment')
                                            @include('components.response.payment')
                                        @endif
                                        @if ($step->answer_type == 'file_upload')
                                            @include('components.response.file_upload')
                                        @endif
                                        @if ($step->answer_type == 'NPS')
                                            @include('components.response.NPS')
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
            @else
                <div class="relative h-full w-full  overflow-hidden">
                    <div class="h-full w-full bg-red-500">
                        <img src="{{ $step->last_cover_image }}" alt=""
                            class="object-cover object-center w-full h-full">
                    </div>

                </div>
            @endif

        @endif

    @endforeach


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




    {{-- <script>
        function initializePayPalButtons() {
            if (typeof paypal === "undefined") {
                console.error("PayPal SDK not loaded.");
                return;
            }

            if (!document.querySelector('#paypal-button-container') || document.querySelector('#paypal-button-container')
                .hasChildNodes()) {
                return; // Avoid re-rendering or if container doesn't exist yet
            }

            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: "10.00" // You can make this dynamic
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        fetch("/paypal-payment-success", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    order_id: data.orderID,
                                    payer_id: data.payerID,
                                    details: details
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert("Payment successful! Your account has been updated.");
                                    window.location.href = '/user/db-access/detail';
                                } else {
                                    alert("Payment verification failed.");
                                }
                            })
                            .catch(error => console.error("Error:", error));
                    });
                }
            }).render("#paypal-button-container");
        }

        Wait for DOM to load
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof paypal === "undefined") {
                console.error("PayPal SDK failed to load.");
                return;
            }

            const observer = new MutationObserver((mutationsList, observer) => {
                const container = document.querySelector("#paypal-button-container");
                if (container && !container.hasChildNodes()) {
                    initializePayPalButtons();
                }
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });
    </script> --}}
    <!-- Paypal -->


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

                            // let id = @json($nextStep);

                            // @this.upload('audioResponse', audioFile, () => {
                            //     @this.call('saveAudio', id);
                            // }, () => {
                            //     alert('Something went wrong while uploading your audio');
                            // });
                            @this.upload('audioResponse', audioFile, () => {
                                @this.call('saveAudio');
                            }, () => {
                                alert('Something went wrong while uploading your audio');
                            });


                        };


                        this.mediaRecorder.start();
                        setTimeout(() => this.stopAudioRecording(),
                            30000);
                    });
                },



                stopAudioRecording() {
                    this.mediaRecorder.stop();
                    setTimeout(() => {
                        this.shouldContinue = true;
                    }, 2000);
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
                        setTimeout(() => this.stopVideoRecording(), 30000);
                    });
                },




                stopVideoRecording() {
                    this.mediaRecorder.stop();
                    // this.shouldContinue = true;
                    setTimeout(() => {
                        this.shouldContinue = true;
                    }, 2000);
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


    <script src="https://upload-widget.cloudinary.com/latest/global/all.js" type="text/javascript"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Livewire.on('setFileType', (file_type) => {
                let formatAllowed = file_type.flat();

                var myWidget = cloudinary.createUploadWidget({
                    cloudName: "dp0bpzh9b",
                    uploadPreset: "video-campaign",
                    resourceType: "raw",
                    clientAllowedFormats: formatAllowed,
                    maxFileSize: 500000000
                }, (error, result) => {
                    if (!error && result && result.event === "success") {
                        // console.log("Done! Here is the image info: ", result.info);
                        let response = result.info;

                        Livewire.dispatch('update-file', {
                            url: response.secure_url
                        })
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
        });
    </script>

    <script>
        const userLang = @json($selectedLang);
    </script>

</div>
