<div class="h-screen overflow-y-auto px-3 md:px-5 space-y-8 pt-5 pb-32" x-data="{ editStep: false }">

    <x-seo::meta />
    @seo([
        'title' => 'Videngager',
        'description' => 'Video funnel',
        'image' => asset('images/video-thumbnail.jpg'),
        'site_name' => config('app.name'),
        'favicon' => asset('favicon.ico'),
    ])
    <x-session-msg />
    
    <!-- Enhanced Header Section -->
    <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-6 shadow-2xl shadow-gray-500/20 border border-gray-200">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
            <div class="flex-grow">
                <input type="text" wire:model="title" wire:keydown.debounce.2000ms="saveTitle()" 
                    class="w-full text-2xl font-bold text-gray-900 bg-transparent border-none outline-none focus:ring-0 placeholder-gray-400" 
                    placeholder="Enter campaign title...">
            </div>

            <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                <!-- Enhanced Controls -->
                <div class="flex items-center space-x-2 bg-white rounded-lg p-2 shadow-sm border border-gray-200">
                    <button class="p-2 text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all duration-200 cursor-pointer" onclick="zoomIn()" title="Zoom In">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6" />
                        </svg>
                    </button>
                    <button class="p-2 text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all duration-200 cursor-pointer" onclick="zoomOut()" title="Zoom Out">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM13.5 10.5h-6" />
                        </svg>
                    </button>
                </div>

                <!-- Enhanced Autoplay Toggle -->
                <div class="bg-white border border-gray-200 rounded-lg px-4 py-3 flex items-center space-x-3 shadow-sm">
                    <span class="text-sm font-semibold text-gray-900">Autoplay video</span>
                    <label class="relative inline-flex items-center cursor-pointer" wire:click="toggleAutoplay">
                        <input type="checkbox" value="1" class="sr-only peer" wire:model="autoplay_video">
                        <div class="w-11 z-0 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-400 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-indigo-500">
                        </div>
                    </label>
                </div>

                <!-- Enhanced Action Buttons -->
                <div class="flex items-center space-x-3">
                    <button id="previewButton" data-dropdown-toggle="previewDropdown" data-dropdown-delay="500"
                        data-dropdown-trigger="hover"
                        class="bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white cursor-pointer focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center space-x-2 shadow-md hover:shadow-lg transition-all duration-200"
                        type="button">
                        <i class='bx bx-play text-lg'></i>
                        <span>Preview</span>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="previewDropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-xl shadow-xl w-48 overflow-hidden border border-gray-200">
                        <ul class="text-sm text-gray-700" aria-labelledby="previewButton">
                            <li>
                                <a href="{{ route('campaign.view', ['uuid' => $campaign->uuid]) }}?preview" target="_blank"
                                    class="block px-4 py-3 hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                                    <p class="font-semibold text-sm">Preview mode</p>
                                    <p class="text-xs text-gray-500">No data gets collected</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('campaign.view', ['uuid' => $campaign->uuid]) }}" target="_blank"
                                    class="block px-4 py-3 hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                                    <p class="font-semibold text-sm">Live mode</p>
                                    <p class="text-xs text-gray-500">Data does get collected</p>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                        class="text-indigo-600 cursor-pointer bg-white hover:bg-indigo-50 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center space-x-2 border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200"
                        type="button">
                        <i class='bx bx-paper-plane text-lg'></i>
                        <span>Share</span>
                    </button>
                </div>
            </div>
        </div>
    </div>




    <!-- Enhanced Steps Section -->
    <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-6 shadow-sm border border-gray-200">
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Campaign Steps</h3>
            <p class="text-gray-600">Manage your video funnel steps and flow</p>
        </div>
        
        <div class="flex gap-4 flex-wrap justify-center" id="zoomContainer" style="zoom: 0.9;">
            @php
                $lastPosition = $steps->max('id');
                $firstPosition = $steps->min('id');
            @endphp

            @forelse ($steps->sortBy('id') as $step)
                <div class="w-64 h-56 flex relative group">
                    <!-- Main Step Card -->
                    <div @click="editStep = true" wire:click="setStep({{ $step->id }}, {{ $step->position }})"
                        class="cursor-pointer shadow-lg hover:shadow-2xl rounded-l-xl border border-gray-200 w-[75%] bg-white hover:border-indigo-300 transition-all duration-300 ease-in-out overflow-hidden group-hover:scale-105">
                        
                        <!-- Step Header -->
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-sm font-bold py-3 px-4 flex justify-between items-center">
                            <span class="truncate capitalize">{{ $step->name }}</span>
                            <span class="rounded-full bg-white text-indigo-600 px-2.5 py-1 text-center text-xs font-bold shadow-sm">
                                {{ $step->position }}
                            </span>
                        </div>
                        
                        <!-- Step Content -->
                        <div class="h-auto">
                            <div class="bg-gray-100 h-full flex justify-center items-center overflow-hidden">
                                @if ($step->id != optional($lastStep)->id)
                                    <img src="{{ asset('images/video-thumbnail.jpg') }}" alt="video thumbnail"
                                        class="w-full h-full object-center object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div style="font-family: 'Dancing Script', cursive !important;"
                                        class="h-full text-3xl font-semibold py-8 text-gray-600 flex items-center justify-center">
                                        @if (count($steps->sortBy('id')) > 1)
                                            <span>Thank You!</span>
                                        @else
                                            <span>Start</span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Step Connections -->
                            @if ($step->id != $lastPosition)
                                <div class="p-2 overflow-auto z-50 bg-gray-50">
                                    @php
                                        $multi_choice_question = json_decode($step->multi_choice_question, true) ?? [];
                                        $multi_choice_setting = json_decode($step->multi_choice_setting, true) ?? [];
                                        $isMultipleSelectEnabled =
                                            collect($multi_choice_setting)->firstWhere('name', 'multiple_select')[
                                                'status'
                                            ] ?? false;
                                    @endphp

                                    @foreach ($multi_choice_question as $index => $option)
                                        @php
                                            $nextPostion = \App\Models\Step::find($option);
                                        @endphp
                                        @if (!$isMultipleSelectEnabled || $loop->first)
                                            <div class="flex items-center space-x-2 mb-2">
                                                <span class="text-indigo-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.49 12 3.75 3.75m0 0-3.75 3.75m3.75-3.75H3.74V4.499" />
                                                    </svg>
                                                </span>
                                                <span class="text-xs font-semibold text-gray-600 bg-white rounded-full px-2 py-1 border border-gray-200">
                                                    {{ optional($nextPostion)->position }}
                                                </span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="rounded-r-xl bg-gradient-to-b from-indigo-600 to-indigo-700 w-[15%] flex items-center justify-center shadow-lg">
                        <div class="text-white text-center">
                            @if ($steps->count() === 1 || $step->id != $lastPosition)
                                <button type="button" class="cursor-pointer p-2 hover:bg-indigo-500 rounded-lg transition-colors duration-200" title="Add Step"
                                    wire:click="addStep({{ $step->position }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                            @endif
                            @if ($steps->count() > 1)
                                @if ($step->id != $firstPosition && $step->id != optional($lastStep)->id)
                                    <button type="button" class="cursor-pointer p-2 hover:bg-red-500 rounded-lg transition-colors duration-200" title="Delete Step"
                                        wire:click="deleteStep( {{ $step->id }},{{ $step->position }})"
                                        wire:loading.attr="disabled">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                    
                    <!-- Connection Line -->
                    @if ($step->id < $lastPosition)
                        <div class="w-[10%] flex items-center justify-center">
                            <div class="w-8 h-0.5 bg-gradient-to-r from-indigo-400 to-indigo-600 rounded-full"></div>
                        </div>
                    @endif
                    
                    <!-- Contact Detail Indicator -->
                    @if ($step->contact_detail)
                        <div class="absolute bottom-2 right-2">
                            <div class="bg-green-500 text-white p-1.5 rounded-full shadow-lg">
                                <i class='bx bxs-contact text-sm'></i>
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class='bx bx-plus text-2xl text-gray-400'></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No steps yet</h3>
                    <p class="text-gray-500">Create your first step to get started</p>
                </div>
            @endforelse
        </div>
    </div>





    <!-- Enhanced Edit Step Modal -->
    <div class="fixed items-center justify-center flex top-0 left-0 mx-auto w-full h-full bg-slate-500/40 z-50 transition duration-300 ease-in-out"
        x-show="editStep" style="display: none;">
        <div @click.away="editStep = false"
            class="w-full h-full shadow-inner overflow-auto transition-all relative duration-300">
            <div class="h-full">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 h-full">
                    <!-- Video Preview Section -->
                    <div class="h-full md:col-span-1 lg:col-span-2 flex justify-center items-center p-6">
                        @if (optional($activeStep)->id == optional($lastStep)->id)
                            <div class="h-[80%] w-[80%] rounded-2xl overflow-hidden shadow-2xl border-4 border-white"
                                wire:key="display-{{ $activeStep }}">
                                <div class="h-full w-full bg-gradient-to-br from-slate-600 to-slate-800">
                                    <img src="{{ optional($activeStep)->last_cover_image ? optional($activeStep)->last_cover_image : 'https://placehold.co/600x400?font=roboto&text=Thank\nYou' }}"
                                        alt="" class="object-cover object-center w-full h-full">
                                </div>
                            </div>
                        @else
                            <div class="h-[80%] w-[80%] rounded-2xl overflow-hidden grid grid-cols-2 shadow-2xl border-4 border-white"
                                wire:key="display-{{ $activeStep }}">
                                <div class="h-full bg-gradient-to-br from-slate-600 to-slate-800 col-span-2 lg:col-span-1">
                                    @if (!empty($activeStep->video_url))
                                        @php
                                            $isExternalVideo = str_contains($activeStep->video_url, 'youtube.com') || str_contains($activeStep->video_url, 'youtu.be') || str_contains($activeStep->video_url, 'vimeo.com');
                                        @endphp
                                        
                                                                                    @if($isExternalVideo)
                                                <!-- External Video (YouTube/Vimeo) -->
                                                @if(str_contains($activeStep->video_url, 'youtube.com') || str_contains($activeStep->video_url, 'youtu.be'))
                                                @php
                                                    $videoId = null;
                                                    if (str_contains($activeStep->video_url, 'youtube.com/watch?v=')) {
                                                        $videoId = substr($activeStep->video_url, strpos($activeStep->video_url, 'v=') + 2);
                                                        $videoId = strtok($videoId, '&');
                                                    } elseif (str_contains($activeStep->video_url, 'youtu.be/')) {
                                                        $videoId = substr($activeStep->video_url, strrpos($activeStep->video_url, '/') + 1);
                                                        $videoId = strtok($videoId, '?');
                                                    }
                                                @endphp
                                                @if($videoId)
                                                    <iframe 
                                                        width="100%" 
                                                        height="100%" 
                                                        src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&controls=1" 
                                                        frameborder="0" 
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                        allowfullscreen
                                                        class="w-full h-full">
                                                    </iframe>
                                                @else
                                                    <img src="{{ asset('images/video-thumbnail.jpg ') }}" alt=""
                                                        class="h-full w-full object-cover object-center">
                                                @endif
                                            @elseif(str_contains($activeStep->video_url, 'vimeo.com'))
                                                @php
                                                    $videoId = substr($activeStep->video_url, strrpos($activeStep->video_url, '/') + 1);
                                                    $videoId = strtok($videoId, '?');
                                                @endphp
                                                @if($videoId)
                                                    <iframe 
                                                        width="100%" 
                                                        height="100%" 
                                                        src="https://player.vimeo.com/video/{{ $videoId }}?h=hash&title=0&byline=0&portrait=0&controls=1" 
                                                        frameborder="0" 
                                                        allow="autoplay; fullscreen; picture-in-picture" 
                                                        allowfullscreen
                                                        class="w-full h-full">
                                                    </iframe>
                                                @else
                                                    <img src="{{ asset('images/video-thumbnail.jpg ') }}" alt=""
                                                        class="h-full w-full object-cover object-center">
                                                @endif
                                            @endif
                                        @else
                                            <!-- Local Video -->
                                            <video width="100%" controls class="mx-auto bg-slate-50 rounded-lg">
                                                <source src="{{ $activeStep->video_url }}" type="video/webm">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    @else
                                        <img src="{{ asset('images/video-thumbnail.jpg ') }}" alt=""
                                            class="h-full w-full object-cover object-center">
                                    @endif
                                </div>
                                <div class="h-full bg-gradient-to-br from-gray-50 to-white hidden lg:flex"></div>
                            </div>
                        @endif
                    </div>

                    <!-- Settings Panel -->
                    <div class="h-full md:col-span-1 lg:col-span-1 bg-white p-6 overflow-y-auto shadow-xl">
                        <!-- Close Button -->
                        <div class="flex justify-end mb-6">
                            <button class="cursor-pointer p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200" @click="editStep = false" wire:click="closeTab">
                                <i class="bx bx-x text-2xl font-bold text-gray-600 hover:text-gray-800"></i>
                            </button>
                        </div>
                        
                        <!-- Step Name Input -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Step Name</label>
                            <input type="text" wire:keydown.debounce.2000ms="saveStepName" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                wire:model="activeName" placeholder="Enter step name (only visible to you)">
                        </div>

                        <!-- Tab Navigation -->
                        @if (optional($activeStep)->id != optional($lastStep)->id)
                            <div class="grid grid-cols-3 gap-2 py-4 mb-6">
                                <button {{ $activeTab === 'video' ? 'disabled' : '' }}
                                    class="px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ $activeTab === 'video' ? 'bg-indigo-100 text-indigo-700 border-2 border-indigo-300' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                                    wire:loading.attr="disabled" wire:click="goToTab('video')"
                                    wire:target="goToTab">
                                    <span wire:loading wire:target="goToTab"><i class='bx bx-loader animate-spin text-sm'></i></span>
                                    <span>Video</span>
                                </button>
                                <button {{ $activeTab === 'answer' ? 'disabled' : '' }}
                                    class="px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ $activeTab === 'answer' ? 'bg-indigo-100 text-indigo-700 border-2 border-indigo-300' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                                    wire:loading.attr="disabled" wire:click="goToTab('answer')"
                                    wire:target="goToTab">
                                    <span wire:loading wire:target="goToTab"><i class='bx bx-loader animate-spin text-sm'></i></span>
                                    <span>Answer</span>
                                </button>
                                <button {{ $activeTab === 'logic' ? 'disabled' : '' }}
                                    class="px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ $activeTab === 'logic' ? 'bg-indigo-100 text-indigo-700 border-2 border-indigo-300' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                                    wire:loading.attr="disabled" wire:click="goToTab('logic')"
                                    wire:target="goToTab">
                                    <span wire:loading wire:target="goToTab"><i class='bx bx-loader animate-spin text-sm'></i></span>
                                    <span>Logic</span>
                                </button>
                            </div>
                        @endif
                        
                        <!-- Tab Content -->
                        <section class="h-[65%] overflow-y-auto">
                            <div class="space-y-6">
                                @if (optional($activeStep)->id != optional($lastStep)->id)
                                    @switch($activeTab)
                                        @case('video')
                                            <div class="">
                                                <livewire:video-setup :activeStep="$activeStep"
                                                    wire:key="video-setup-{{ $activeStep }}" />
                                            </div>
                                        @break

                                        @case('answer')
                                            <div class="space-y-6">
                                                <div>
                                                    <label for="answer_type" class="block text-sm font-medium text-gray-700 mb-2">Select answer type:</label>
                                                    <select wire:model.live="answer_type" id="answer_type"
                                                        wire:change="updateAnswerType()" 
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                                        <option value="open_ended" selected>Open Ended</option>
                                                        <option value="ai_chat">AI Chat</option>
                                                        <option value="multi_choice">Multiple Choice</option>
                                                        <option value="button">Button</option>
                                                        <option value="calender">Calendar</option>
                                                        <option value="NPS">NPS</option>
                                                        <option value="file_upload">File Upload</option>
                                                        <option value="payment">Payment</option>
                                                        <option value="timer">Timer</option>
                                                        <option value="map">Map</option>
                                                    </select>
                                                </div>

                                                <div>
                                                    @switch($answer_type)
                                                        @case('open_ended')
                                                            <livewire:open-ended :activeStep="$activeStep"
                                                                wire:key="answer-open-ended-{{ $activeStep }}" />
                                                        @break

                                                        @case('multi_choice')
                                                            <livewire:multi-choice :activeStep="$activeStep"
                                                                wire:key="answer-multi-choice-{{ $activeStep }}" />
                                                        @break

                                                        @case('button')
                                                            <livewire:button-component :activeStep="$activeStep"
                                                                wire:key="answer-button-{{ $activeStep }}" />
                                                        @break

                                                        @case('calender')
                                                            <livewire:calender-component :activeStep="$activeStep"
                                                                wire:key="answer-calender-{{ $activeStep }}" />
                                                        @break

                                                        @case('payment')
                                                            <livewire:payment-component :activeStep="$activeStep" :campaign="$campaign"
                                                                wire:key="answer-payment-{{ $activeStep }}" />
                                                        @break

                                                        @case('file_upload')
                                                            <livewire:file-upload :activeStep="$activeStep"
                                                                wire:key="answer-file-{{ $activeStep }}" />
                                                        @break

                                                        @case('NPS')
                                                            <livewire:n-p-s-component :activeStep="$activeStep"
                                                                wire:key="answer-nps-{{ $activeStep }}" />
                                                        @break

                                                        @case('ai_chat')
                                                            <livewire:ai-chat wire:key="answer-ai-{{ now() }}" />
                                                        @break

                                                        @case('timer')
                                                            <livewire:timer-component :activeStep="$activeStep" wire:key="answer-timer-{{ $activeStep }}" />
                                                        @break

                                                        @case('map')
                                                            <livewire:map-component :activeStep="$activeStep" wire:key="answer-map-{{ $activeStep }}" />
                                                        @break
                                                    @endswitch
                                                </div>
                                            </div>
                                        @break

                                        @case('logic')
                                            <div class="">
                                                <livewire:logic-component :activeStep="$activeStep" :campaign="$campaign"
                                                    wire:key="multi-choice-{{ $activeStep }}" />
                                            </div>
                                        @break
                                    @endswitch
                                @else
                                    <x-session-msg />

                                    <div class="space-y-4">
                                        <div class="relative">
                                            <label title="Click to upload" for="button2"
                                                class="cursor-pointer flex items-center gap-4 px-6 py-4 before:border-gray-400/60 hover:before:border-gray-300 group before:bg-gray-100 before:absolute before:inset-0 before:rounded-3xl before:border before:border-dashed before:transition-transform before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95">
                                                <div class="w-max relative">
                                                    <img class="w-12"
                                                        src="https://www.svgrepo.com/show/485545/upload-cicle.svg"
                                                        alt="file upload icon" width="512" height="512">
                                                </div>
                                                <div class="relative">
                                                    <span class="block text-base font-semibold relative text-blue-900 group-hover:text-blue-500">
                                                        Upload a file
                                                    </span>
                                                    <span class="mt-0.5 block text-sm text-gray-500">Max 2 MB</span>
                                                </div>
                                            </label>
                                            <input type="file" wire:model="thank_you_image" id="button2" class="hidden">
                                        </div>

                                        <div class="max-w-sm">
                                            <button class="w-full bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-medium py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200" 
                                                wire:loading.attr="disabled" wire:target="saveCoverImage" wire:click="saveCoverImage()">
                                                <span wire:loading.remove wire:target="saveCoverImage">Upload</span>
                                                <span wire:loading wire:target="saveCoverImage" class="">Loading...</span>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                @if (optional($activeStep)->id != optional($lastStep)->id)
                                    <livewire:contact-form :activeStep="$activeStep ?? null" :activeTab="$activeTab"
                                        wire:key="open-ended-{{ now() }}" />
                                @endif
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Share Modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden bg-slate-500/40 fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-xl shadow-xl border border-gray-200">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 rounded-t-xl">
                    <h3 class="text-xl font-semibold text-gray-900">
                        How would you like to share your Campaign?
                    </h3>
                    <button type="button"
                        class="text-gray-400 cursor-pointer bg-transparent hover:bg-gray-100 hover:text-gray-600 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors duration-200"
                        data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="mx-auto max-w-xl" x-data="{ showTab: null }">
                        <section x-show="showTab == null" style="display: none;">
                            <!-- Share Options Grid -->
                            <div class="grid md:grid-cols-3 gap-4 mb-6">
                                <div @click="showTab = 'email'"
                                    class="bg-gradient-to-br from-indigo-50 to-indigo-100 border-2 border-indigo-200 rounded-xl hover:shadow-lg hover:border-indigo-400 hover:bg-indigo-200 p-4 transition-all duration-300 cursor-pointer ease-in-out group">
                                    <div class="bg-slate-900 w-full mb-4 rounded-lg overflow-hidden">
                                        <img src="{{ asset('images/video-thumbnail.jpg') }}" alt=""
                                            class="w-full object-center object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                    <p class="text-center text-sm font-semibold text-indigo-700">
                                        Send via email
                                    </p>
                                </div>
                                
                                <div @click="showTab = 'embed'"
                                    class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl hover:shadow-lg hover:border-blue-400 hover:bg-blue-200 p-4 transition-all duration-300 cursor-pointer ease-in-out group">
                                    <div class="bg-slate-900 w-full mb-4 rounded-lg overflow-hidden">
                                        <img src="{{ asset('images/video-thumbnail.jpg') }}" alt=""
                                            class="w-full object-center object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                    <p class="text-center text-sm font-semibold text-blue-700">
                                        Copy embed code
                                    </p>
                                </div>
                                
                                <div @click="showTab = 'social_share'"
                                    class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-xl hover:shadow-lg hover:border-green-400 hover:bg-green-200 p-4 transition-all duration-300 cursor-pointer ease-in-out group">
                                    <div class="bg-slate-900 w-full mb-4 rounded-lg overflow-hidden">
                                        <img src="{{ asset('images/video-thumbnail.jpg') }}" alt=""
                                            class="w-full object-center object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                    <p class="text-center text-sm font-semibold text-green-700">
                                        Social Share
                                    </p>
                                </div>
                            </div>

                            <!-- Campaign URL Section -->
                            <div class="w-full max-w-md mx-auto">
                                <div class="mb-3 flex justify-between items-center">
                                    <label for="campaign-url" class="text-sm font-medium text-gray-900">Campaign link:</label>
                                </div>
                                <div class="flex items-center">
                                    <span class="shrink-0 z-10 inline-flex items-center py-3 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg">URL</span>
                                    <div class="relative w-full">
                                        <input id="campaign-url" type="text"
                                            aria-describedby="helper-text-explanation"
                                            class="bg-gray-50 border border-e-0 border-gray-300 text-gray-500 text-sm border-s-0 focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3"
                                            value="{{ route('campaign.view', ['uuid' => $campaign->uuid]) }}"
                                            readonly />
                                    </div>
                                    <button onclick="copyCampaignUrl()"
                                        class="shrink-0 z-10 cursor-pointer inline-flex items-center py-3 px-4 text-sm font-medium text-center text-white bg-indigo-600 rounded-e-lg hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 border border-indigo-600 hover:border-indigo-700 transition-colors duration-200"
                                        type="button">
                                        <span id="default-icon">
                                            <svg class="w-4 h-4" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 18 20">
                                                <path
                                                    d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                            </svg>
                                        </span>
                                        <span id="success-icon" class="hidden">
                                            <svg class="w-4 h-4" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 16 12">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M1 5.917 5.724 10.5 15 1.5" />
                                            </svg>
                                        </span>
                                    </button>
                                    <div id="tooltip-campaign-url" role="tooltip"
                                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip">
                                        <span id="default-tooltip-message">Copy link</span>
                                        <span id="success-tooltip-message" class="hidden">Copied!</span>
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                                <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500">
                                    Copy link</p>
                            </div>
                        </section>

                        <!-- Tab Content Sections -->
                        <section x-show="showTab != null" style="display: none;" class="">
                            <div class="mb-6">
                                <button @click="showTab = null"
                                    class="cursor-pointer text-md font-semibold text-indigo-600 hover:text-indigo-800 transition-colors duration-200 flex items-center gap-2">
                                    <i class='bx bx-arrow-back'></i>
                                    <span>Back</span>
                                </button>
                            </div>
                            
                            <!-- Email Tab -->
                            <div x-show="showTab == 'email'" style="display: none;">
                                <form action="" class="space-y-4 mx-auto max-w-md mb-8">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                        <input type="text" name="name" placeholder="Name"
                                            wire:model="name"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                        <input type="email" name="email" placeholder="Email*"
                                            wire:model="email"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                    </div>
                                    <button type="button" wire:loading.attr="disabled"
                                        wire:target="inviteUser" 
                                        class="w-full bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-medium py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200"
                                        wire:click="inviteUser">
                                        <span wire:loading.remove wire:target="inviteUser">Send</span>
                                        <span wire:loading wire:target="inviteUser">Loading...</span>
                                    </button>
                                </form>
                            </div>
                            
                            <!-- Embed Tab -->
                            <div x-show="showTab == 'embed'" style="display: none;">
                                <div class="w-full max-w-lg mx-auto">
                                    <div class="mb-3 flex justify-between items-center">
                                        <p class="text-sm font-medium text-gray-900">Embed your Campaign anywhere in your website:</p>
                                    </div>
                                    <div class="relative bg-gray-100 rounded-lg p-4 h-28 shadow-lg">
                                        <div class="overflow-auto max-h-full">
                                            <pre><code id="code-block" class="text-sm text-gray-700 whitespace-pre">&#x3C;iframe src="{{ route('campaign.view', ['uuid' => $this->campaign->uuid]) }}" allow="camera *; microphone *; autoplay *; encrypted-media *; fullscreen *; display-capture *;" width="100%" height="600px" style="border: none; border-radius: 24px"&#x3E;&#x3C;/iframe&#x3E;</code></pre>
                                        </div>
                                        <div class="absolute top-2 end-2 bg-gray-100">
                                            <button onclick="copyEmbedCode()"
                                                class="text-gray-900 cursor-pointer m-0.5 hover:bg-gray-200 rounded-lg py-2 px-2.5 inline-flex items-center justify-center bg-white border-gray-200 border h-8 transition-colors duration-200">
                                                <span id="embed-default-message">
                                                    <span class="inline-flex items-center">
                                                        <svg class="w-3 h-3 me-1.5" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 18 20">
                                                            <path
                                                                d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                                        </svg>
                                                        <span class="text-xs font-semibold">Copy code</span>
                                                    </span>
                                                </span>
                                                <span id="embed-success-message" class="hidden">
                                                    <span class="inline-flex items-center">
                                                        <svg class="w-3 h-3 text-blue-700 me-1.5"
                                                            aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 16 12">
                                                            <path stroke="currentColor"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M1 5.917 5.724 10.5 15 1.5" />
                                                        </svg>
                                                        <span class="text-xs font-semibold text-blue-700">Copied</span>
                                                    </span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Copy Code</p>
                                </div>
                            </div>
                            
                            <!-- Social Share Tab -->
                            <div x-show="showTab == 'social_share'" style="display: none;">
                                <h4 class="text-xl font-semibold text-gray-900 mb-4">Social Share</h4>
                                <div id="social-links" class="mt-4">
                                    <ul class="grid grid-cols-2 gap-3 items-start sm:items-center">
                                        <li class="flex items-center gap-3 border-2 border-gray-200 rounded-xl bg-white shadow-md hover:shadow-lg hover:border-blue-400 transition-all duration-300 ease-in-out">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('campaign.view', ['uuid' => $this->campaign->uuid]) }}"
                                                class="flex items-center gap-3 text-blue-600 hover:text-blue-800 text-lg w-full py-3 px-4"
                                                target="_blank" title="Share on Facebook">
                                                <span class="fab fa-facebook-square text-2xl"></span>
                                                <div>
                                                    <p class="font-semibold">Facebook</p>
                                                    <p class="text-sm text-gray-500">Share on Facebook</p>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="flex items-center gap-3 border-2 border-gray-200 rounded-xl bg-white shadow-md hover:shadow-lg hover:border-slate-400 transition-all duration-300 ease-in-out">
                                            <a href="https://twitter.com/intent/tweet?text=Share+title&url={{ route('campaign.view', ['uuid' => $this->campaign->uuid]) }}"
                                                class="flex items-center gap-3 text-slate-800 hover:text-slate-900 text-lg w-full py-3 px-4"
                                                target="_blank" title="Share on Twitter">
                                                <span class="fab fa-x-twitter text-2xl"></span>
                                                <div>
                                                    <p class="font-semibold">X</p>
                                                    <p class="text-sm text-gray-500">Share on Twitter</p>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="flex items-center gap-3 border-2 border-gray-200 rounded-xl bg-white shadow-md hover:shadow-lg hover:border-blue-500 transition-all duration-300 ease-in-out">
                                            <a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url={{ route('campaign.view', ['uuid' => $this->campaign->uuid]) }}&title=Share+title&summary=Extra+linkedin+summary+can+be+passed+here"
                                                class="flex items-center gap-3 text-blue-700 hover:text-blue-900 text-lg w-full py-3 px-4"
                                                target="_blank" title="Share on LinkedIn">
                                                <span class="fab fa-linkedin text-2xl"></span>
                                                <div>
                                                    <p class="font-semibold">LinkedIn</p>
                                                    <p class="text-sm text-gray-500">Share on LinkedIn</p>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="flex items-center gap-3 border-2 border-gray-200 rounded-xl bg-white shadow-md hover:shadow-lg hover:border-green-500 transition-all duration-300 ease-in-out">
                                            <a href="https://wa.me/?text={{ route('campaign.view', ['uuid' => $this->campaign->uuid]) }}"
                                                class="flex items-center gap-3 text-green-500 hover:text-green-700 text-lg w-full py-3 px-4"
                                                target="_blank" title="Share on WhatsApp">
                                                <span class="fab fa-whatsapp text-2xl"></span>
                                                <div>
                                                    <p class="font-semibold">WhatsApp</p>
                                                    <p class="text-sm text-gray-500">Share on Whatsapp</p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Styles -->
    <style>
        button:disabled {
            background-color: gray;
            cursor: not-allowed;
        }
        
        /* Enhanced form controls */
        .form-control {
            @apply w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200;
        }
        
        /* Enhanced buttons */
        .btn {
            @apply bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-medium py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200;
        }
        
        .btn-danger {
            @apply bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-medium py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200;
        }
        
        .btn3 {
            @apply bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-medium py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200;
        }
        
        /* Enhanced dropdown styling */
        #previewDropdown {
            @apply z-10 hidden bg-white divide-y divide-gray-100 rounded-xl shadow-xl w-48 overflow-hidden border border-gray-200;
        }
        
        #previewDropdown ul li a {
            @apply block px-4 py-3 hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200;
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

        // Copy campaign URL function
        function copyCampaignUrl() {
            const urlInput = document.getElementById('campaign-url');
            const defaultIcon = document.getElementById('default-icon');
            const successIcon = document.getElementById('success-icon');
            
            // Get the URL value
            const urlToCopy = urlInput.value;
            
            // Try modern clipboard API first
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(urlToCopy).then(() => {
                    showCopySuccess(defaultIcon, successIcon);
                }).catch(err => {
                    console.error('Modern clipboard failed, trying fallback:', err);
                    fallbackCopy(urlToCopy, defaultIcon, successIcon);
                });
            } else {
                // Fallback for older browsers or non-secure contexts
                fallbackCopy(urlToCopy, defaultIcon, successIcon);
            }
        }
        
        // Fallback copy function
        function fallbackCopy(textToCopy, defaultIcon, successIcon) {
            // Create a temporary textarea element
            const textArea = document.createElement('textarea');
            textArea.value = textToCopy;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            
            // Select and copy
            textArea.focus();
            textArea.select();
            
            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showCopySuccess(defaultIcon, successIcon);
                } else {
                    console.error('Fallback copy failed');
                    alert('Failed to copy link to clipboard');
                }
            } catch (err) {
                console.error('Fallback copy error:', err);
                alert('Failed to copy link to clipboard');
            }
            
            // Clean up
            document.body.removeChild(textArea);
        }
        
        // Show copy success state
        function showCopySuccess(defaultIcon, successIcon) {
            // Show success state
            defaultIcon.classList.add('hidden');
            successIcon.classList.remove('hidden');
            
            // Change button color to green temporarily
            const button = defaultIcon.closest('button');
            button.classList.remove('bg-indigo-600', 'hover:bg-indigo-700', 'border-indigo-600', 'hover:border-indigo-700');
            button.classList.add('bg-green-600', 'hover:bg-green-700', 'border-green-600', 'hover:border-green-700');
            
            // Reset after 2 seconds
            setTimeout(() => {
                defaultIcon.classList.remove('hidden');
                successIcon.classList.add('hidden');
                button.classList.remove('bg-green-600', 'hover:bg-green-700', 'border-green-600', 'hover:border-green-700');
                button.classList.add('bg-indigo-600', 'hover:bg-indigo-700', 'border-indigo-600', 'hover:border-indigo-700');
            }, 2000);
            
            // Show toast notification
            if (typeof Toastify !== 'undefined') {
                Toastify({
                    text: "Campaign link copied to clipboard!",
                    position: "center",
                    duration: 2000,
                    backgroundColor: "linear-gradient(to right, #56ab2f, #a8e063)"
                }).showToast();
            }
        }

        // Copy embed code function
        function copyEmbedCode() {
            const codeBlock = document.getElementById('code-block');
            const defaultMessage = document.getElementById('embed-default-message');
            const successMessage = document.getElementById('embed-success-message');

            // Get the code content
            const codeToCopy = codeBlock.textContent;

            // Try modern clipboard API first
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(codeToCopy).then(() => {
                    showEmbedCopySuccess(defaultMessage, successMessage);
                }).catch(err => {
                    console.error('Modern clipboard failed, trying fallback:', err);
                    fallbackCopyEmbed(codeToCopy, defaultMessage, successMessage);
                });
            } else {
                // Fallback for older browsers or non-secure contexts
                fallbackCopyEmbed(codeToCopy, defaultMessage, successMessage);
            }
        }
        
        // Fallback copy function for embed code
        function fallbackCopyEmbed(textToCopy, defaultMessage, successMessage) {
            // Create a temporary textarea element
            const textArea = document.createElement('textarea');
            textArea.value = textToCopy;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            
            // Select and copy
            textArea.focus();
            textArea.select();
            
            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showEmbedCopySuccess(defaultMessage, successMessage);
                } else {
                    console.error('Fallback copy failed');
                    alert('Failed to copy embed code to clipboard');
                }
            } catch (err) {
                console.error('Fallback copy error:', err);
                alert('Failed to copy embed code to clipboard');
            }
            
            // Clean up
            document.body.removeChild(textArea);
        }
        
        // Show embed copy success state
        function showEmbedCopySuccess(defaultMessage, successMessage) {
            // Show success state
            defaultMessage.classList.add('hidden');
            successMessage.classList.remove('hidden');
            
            // Reset after 2 seconds
            setTimeout(() => {
                defaultMessage.classList.remove('hidden');
                successMessage.classList.add('hidden');
            }, 2000);
            
            // Show toast notification
            if (typeof Toastify !== 'undefined') {
                Toastify({
                    text: "Embed code copied to clipboard!",
                    position: "center",
                    duration: 2000,
                    backgroundColor: "linear-gradient(to right, #56ab2f, #a8e063)"
                }).showToast();
            }
        }




        document.addEventListener('DOMContentLoaded', function() {

            Livewire.on('notify', (data) => {
                if (data.status == 'success') {
                    Toastify({
                        text: `${data.msg}`,
                        // gravity: "bottom",
                        position: "center",
                        duration: 3000,
                        backgroundColor: "linear-gradient(to right, #56ab2f, #a8e063)"
                    }).showToast();

                }
                if (data.status == 'error') {
                    Toastify({
                        text: `${data.msg}`,
                        // gravity: "bottom",
                        position: "center",
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
                    clientAllowedFormats: ["mp4", "avi", "mov", "webm", "MKV"],
                    maxFileSize: 500000000
                }, (error, result) => {
                    if (!error && result && result.event === "success") {
                        // console.log("Done! Here is the image info: ", result.info);
                        let response = result.info;

                        Livewire.dispatch('update-video', {
                            url: response.secure_url
                        })

                        Toastify({
                            text: `Uploaded! Successfully`,
                            position: "center",
                            duration: 3000,
                            backgroundColor: "linear-gradient(to right, #56ab2f, #a8e063)"
                        }).showToast();

                        myWidget.close();
                        if (uploadButton) {
                            uploadButton.removeEventListener("click", openWidget);
                        }
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


            // function toCopy(copyDiv) {
            //     var range = document.createRange();
            //     range.selectNode(copyDiv);
            //     window.getSelection().removeAllRanges();
            //     window.getSelection().addRange(range);
            //     document.execCommand("copy");
            // }

            function toCopy(inputElement) {
                inputElement.select();
                inputElement.setSelectionRange(0, 99999); // For mobile devices
                document.execCommand("copy");
            }
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

            window.addEventListener('error', function(event) {
                const errorMessage = event?.error?.message || event?.message;

                if (errorMessage && errorMessage.includes('Component not found')) {
                    console.warn('🔄 Livewire component missing. Reloading page...');
                    // alert('Error occured: refreshing page')
                    window.location.reload();
                }
            });
            window.addEventListener('unhandledrejection', function(event) {
                const errorMessage = event?.reason?.message || event?.reason;

                if (errorMessage && errorMessage.includes('Component not found')) {
                    console.warn('🔄 Livewire component missing (from promise). Reloading page...');
                    // alert('An error occurred. Reloading the page...');
                    window.location.reload();
                }
            });
        </script>
    @endsection
</div>
