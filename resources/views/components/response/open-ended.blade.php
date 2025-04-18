<div x-data="responseRecorder()" class="w-full ">
    {{-- <div x-data="{ openResponse: null }" class="w-full "> --}}
    <div x-show="openResponse == null" style="display: none;">
        <div class="flex justify-center space-x-2">
            @if ($step->allow_audio_response)
                <div @click="openResponse = 'audio' "
                    class="rounded-md bg-slate-800 py-5 px-10 text-white cursor-pointer hover:opacity-90 hover:shadow-xl transition duration-500 ease-in-out">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                        </svg>
                    </span>
                </div>
            @endif
            @if ($step->allow_video_response)
                <div @click="openResponse = 'video' "
                    class="rounded-md bg-slate-800 py-5 px-10 text-white cursor-pointer hover:opacity-90 hover:shadow-xl transition duration-500 ease-in-out">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </span>
                </div>
            @endif
            @if ($step->allow_text_response)
                <div @click="openResponse = 'text' "
                    class="rounded-md bg-slate-800 py-5 px-10 text-white cursor-pointer hover:opacity-90 hover:shadow-xl transition duration-500 ease-in-out">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                        </svg>
                    </span>
                </div>
            @endif
            @if (!$step->allow_audio_response && !$step->allow_video_response && !$step->allow_text_response)
                <div class="w-full">
                    {{-- <textarea name="" id="" rows="10" class="w-full" placeholder="Enter text here"></textarea> --}}
                    <textarea id="textResponse" rows="10" x-model="textResponse" wire:model="textResponse" class="w-full p-3"
                        placeholder="Enter text here" @input="shouldContinue = textResponse.trim() !== ''"></textarea>
                    <div class="flex space-x-3">


                        {{-- @foreach ($previous as $index => $prev)
                    <button class="btn cursor-pointer"
                        wire:click="goToPrevious({{ $step->id }},'{{ $index }}')">
                        Back
                    </button>
                @endforeach --}}
                        @if ($lastPosition != $step->id)
                            @foreach ($nexts as $index => $next)
                                <button class="btn cursor-pointer" x-show="shouldContinue"  wire:loading.attr="disabled"
                                    wire:target="goToNext"
                                    wire:click="goToNext({{ $step->id }},'{{ $index }}')">
                                    <span wire:loading.remove wire:target="goToNext">Continue</span>
                                    <span wire:loading wire:target="goToNext" class="">
                                        Loading...
                                    </span>
                                </button>
                            @endforeach
                        @else
                            <button class="btn cursor-pointer">
                                Finish
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-20 mx-auto max-w-40">
            @if ($nextStep !== $firstPosition)
                @foreach ($previous as $index => $prev)
                    <button class="btn cursor-pointer"
                        wire:click="goToPrevious({{ $step->id }},'{{ $index }}')">
                        Back
                    </button>
                @endforeach
            @endif
        </div>
    </div>

    <div x-show="openResponse == 'video'" style="display: none;">
        <div>
            video
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
            @if ($lastPosition != $step->id)
                @foreach ($nexts as $index => $next)
                    <button class="btn cursor-pointer" x-show="shouldContinue"  wire:loading.attr="disabled"
                        wire:target="goToNext" wire:click="goToNext({{ $step->id }},'{{ $index }}')">
                        <span wire:loading.remove wire:target="goToNext">Continue</span>
                        <span wire:loading wire:target="goToNext" class="">
                            Loading...
                        </span>
                    </button>
                @endforeach
            @else
                <button class="btn cursor-pointer">
                    Continue
                </button>
            @endif
        </div>
    </div>
    <div x-show="openResponse == 'audio'" style="display: none;">
        <div>
            audio
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
            @if ($lastPosition != $step->id)
                @foreach ($nexts as $index => $next)
                    <button class="btn cursor-pointer" x-show="shouldContinue"  wire:loading.attr="disabled"
                        wire:target="goToNext" wire:click="goToNext({{ $step->id }},'{{ $index }}')">
                        <span wire:loading.remove wire:target="goToNext">Continue</span>
                        <span wire:loading wire:target="goToNext" class="">
                            Loading...
                        </span>
                    </button>
                @endforeach
            @else
                <button class="btn cursor-pointer">
                    Finish
                </button>
            @endif
        </div>
    </div>
    <div x-show="openResponse == 'text'" style="display: none;" class="w-full">
        {{-- <textarea name="" id="" rows="10" class="w-full" placeholder="Enter text here"></textarea> --}}
        <textarea id="textResponse" rows="10" x-model="textResponse" wire:model="textResponse" class="w-full p-3"
            placeholder="Enter text here" @input="shouldContinue = textResponse.trim() !== ''"></textarea>
        <div class="flex space-x-3">
            {{-- @foreach ($previous as $index => $prev)
                <button class="btn cursor-pointer"
                    wire:click="goToPrevious({{ $step->id }},'{{ $index }}')">
                    Back
                </button>
            @endforeach --}}
            @if ($lastPosition != $step->id)
                @foreach ($nexts as $index => $next)
                    <button class="btn cursor-pointer" x-show="shouldContinue"  wire:loading.attr="disabled"
                        wire:target="goToNext" wire:click="goToNext({{ $step->id }},'{{ $index }}')">
                        <span wire:loading.remove wire:target="goToNext">Continue</span>
                        <span wire:loading wire:target="goToNext" class="">
                            Loading...
                        </span>
                    </button>
                @endforeach
            @else
                <button class="btn cursor-pointer">
                    Finish
                </button>
            @endif
        </div>
    </div>

</div>
