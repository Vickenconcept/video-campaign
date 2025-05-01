<div class="h-screen">
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <div class="relative h-full w-full  overflow-hidden grid md:grid-cols-2">


        <div class="h-screen md:h-full w-full bg-slate-300 flex items-center justify-center ">
            <div class="relative max-w-full max-h-full">
                @if ($response->video)
                    <video controls class="mx-auto bg-slate-50/10 max-w-full max-h-full object-contain">
                        <source src="{{ $response->video }}" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                @endif
                @if ($response->text)
                   <div>
                    <p class="max-w-lg mx-auto bg-gray-100 p-4 rounded-md overflow-x-auto">{{ $response->text }}</p>
                   </div>
                @endif

                @if ($response->audio)
                    <div class="">
                        <div class="max-w-md mx-auto">
                            <audio src="{{ $response->audio }}" controls></audio>
                        </div>
                    </div>
                @endif
               
            </div>
        </div>

        <div
            class="absolute w-full left-0 bottom-0 md:relative md:h-full bg-black/30 md:bg-white flex justify-center items-center overflow-y-auto pb-10">
            <div class="h-[80%] w-[80%] md:border rounded-md flex justify-center items-center overflow-y-auto ">

                <div class="w-[80%] ">
                    <div class="w-full">







                        <div x-data="responseRecorder()" class="w-full ">
                            {{-- <div x-data="{ openResponse: null }" class="w-full "> --}}
                            <div x-show="openResponse == null" style="display: none;">
                                <div class="flex justify-center space-x-2">
                                    <div @click="openResponse = 'audio' "
                                        class="rounded-md bg-slate-800 py-5 px-10 text-white cursor-pointer hover:opacity-90 hover:shadow-xl transition duration-500 ease-in-out">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                                            </svg>
                                        </span>
                                    </div>

                                    <div @click="openResponse = 'video' "
                                        class="rounded-md bg-slate-800 py-5 px-10 text-white cursor-pointer hover:opacity-90 hover:shadow-xl transition duration-500 ease-in-out">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                            </svg>
                                        </span>
                                    </div>

                                    <div @click="openResponse = 'text' "
                                        class="rounded-md bg-slate-800 py-5 px-10 text-white cursor-pointer hover:opacity-90 hover:shadow-xl transition duration-500 ease-in-out">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                            </svg>
                                        </span>
                                    </div>

                                </div>

                                <div class="mt-20 mx-auto max-w-40">

                                    <button class="btn cursor-pointer" x-show="shouldContinue"
                                        wire:loading.attr="disabled" wire:target="sendFeedback"
                                        wire:click="sendFeedback()">
                                        <span wire:loading.remove wire:target="sendFeedback">Continue</span>
                                        <span wire:loading wire:target="sendFeedback" class="">
                                            Loading...
                                        </span>
                                    </button>

                                </div>
                            </div>

                            <div x-show="openResponse == 'video'" style="display: none;">
                                <div>
                                    <video x-ref="videoPlayer" autoplay muted controls class="w-full max-w-md"></video>
                                    <input type="file" wire:model="videoResponse" x-ref="videoUpload" class="hidden">
                                    <div class="my-4" x-data="{ isPlaying: false }">
                                        <button x-show="!isPlaying"
                                            class="rounded-md px-4 flex items-center space-x-2 py-2 cursor-pointer hover:shadow-lg shadow-inner hover:bg-white transition duration-500 ease-in-out border bg-slate-300 border-slate-500"
                                            @click="startVideoRecording(), isPlaying = true">
                                            <i class='bx bx-play text-2xl'></i>
                                            <span>Start Video</span>
                                        </button>
                                        <button x-show="isPlaying"
                                            class="rounded-md px-4 flex items-center space-x-2 py-2 cursor-pointer hover:shadow-lg shadow-inner hover:bg-white transition duration-500 ease-in-out border bg-slate-300 border-slate-500"
                                            @click="stopVideoRecording(), isPlaying = false">
                                            <i class='bx bx-pause text-2xl'></i>
                                            <span>Stop Video</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex space-x-3">

                                    <button class="btn cursor-pointer" x-show="shouldContinue"
                                        wire:loading.attr="disabled" wire:target="sendFeedback"
                                        wire:click="sendFeedback()">
                                        <span wire:loading.remove wire:target="sendFeedback">Continue</span>
                                        <span wire:loading wire:target="sendFeedback" class="">
                                            Loading...
                                        </span>
                                    </button>

                                </div>
                            </div>
                            <div x-show="openResponse == 'audio'" style="display: none;">
                                <div>
                                    <audio x-ref="audioPlayer" controls></audio>
                                    <input type="file" wire:model="audioResponse" x-ref="videoUpload" class="hidden">
                                    <div class="my-4" x-data="{ isPlaying: false }">
                                        <button x-show="!isPlaying"
                                            class="rounded-md px-4 flex items-center space-x-2 py-2 cursor-pointer hover:shadow-lg shadow-inner hover:bg-white transition duration-500 ease-in-out border bg-slate-300 border-slate-500"
                                            @click="startAudioRecording(), isPlaying = true">
                                            <i class='bx bx-play text-2xl'></i>
                                            <span>Start Audio</span>
                                        </button>
                                        <button x-show="isPlaying"
                                            class="rounded-md px-4 flex items-center space-x-2 py-2 cursor-pointer hover:shadow-lg shadow-inner hover:bg-white transition duration-500 ease-in-out border bg-slate-300 border-slate-500"
                                            @click="stopAudioRecording(), isPlaying = false">
                                            <i class='bx bx-pause text-2xl'></i>
                                            <span>Stop Audio</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex space-x-3">
                                    <button class="btn cursor-pointer" x-show="shouldContinue"
                                        wire:loading.attr="disabled" wire:target="sendFeedback"
                                        wire:click="sendFeedback()">
                                        <span wire:loading.remove wire:target="sendFeedback">Continue</span>
                                        <span wire:loading wire:target="sendFeedback" class="">
                                            Loading...
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <div x-show="openResponse == 'text'" style="display: none;" class="w-full">
                                <textarea id="textResponse" rows="10" x-model="textResponse" wire:model="textResponse" class="w-full p-3"
                                    placeholder="Enter text here" @input="shouldContinue = textResponse.trim() !== ''"></textarea>
                                <div class="flex space-x-3">

                                    <button class="btn cursor-pointer" x-show="shouldContinue"
                                        wire:loading.attr="disabled" wire:target="saveText"
                                        wire:click="saveText()">
                                        <span wire:loading.remove wire:target="saveText">Continue</span>
                                        <span wire:loading wire:target="saveText" class="">
                                            Loading...
                                        </span>
                                    </button>

                                </div>
                            </div>

                        </div>






                    </div>
                </div>

            </div>
        </div>
    </div>





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

</div>
