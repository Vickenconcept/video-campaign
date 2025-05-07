<div class="h-screen overflow-y-auto px-5 space-y-10" x-data="{ editStep: false }">
    {{-- Because she competes with no one, no one can compete with her. --}}
    {{-- {{ $campaign }} --}}

    <x-seo::meta />
    @seo([
        'title' => 'Campain Video ask',
        'description' => 'Campain',
        'image' => asset('images/video-thumbnail.jpg'),
        'site_name' => config('app.name'),
        'favicon' => asset('images/fav-image.png'),
    ])
    <x-session-msg />
    <div>
        <div class="flex justify-between items-center space-x-5">
            <div class="flex-grow">
                <input type="text" wire:model="title" wire:keydown.debounce.2000ms="saveTitle()" class="form-control">
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
            <div class="flex items-center space-x-3">

                <button id="previewButton" data-dropdown-toggle="previewDropdown" data-dropdown-delay="500"
                    data-dropdown-trigger="hover"
                    class="text-white bg-gray-800 cursor-pointer hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 text-center inline-flex items-center space-x-2 border "
                    type="button">
                    <i class='bx bx-play text-xl'></i>
                    <span>Preview</span>
                </button>

                <!-- Dropdown menu -->
                <div id="previewDropdown"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-xl w-44 overflow-hidden ">
                    <ul class=" text-sm text-gray-700 " aria-labelledby="previewButton">
                        <li>
                            <a href="{{ route('campaign.view', ['uuid' => $campaign->uuid]) }}?preview" target="_blank"
                                class="block px-4 py-2 hover:bg-gray-100 ">
                                <p class="font-semibold text-sm">Preview mode</p>
                                <p class="text-xs text-gray-500">No data gets collected</p>
                            </a>
                            <a href="{{ route('campaign.view', ['uuid' => $campaign->uuid]) }}" target="_blank"
                                class="block px-4 py-2 hover:bg-gray-100 ">
                                <p class="font-semibold text-sm">Live mode</p>
                                <p class="text-xs text-gray-500">Data does get collected</p>
                            </a>
                        </li>

                    </ul>
                </div>





                <!-- Modal toggle -->
                <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                    class="text-gray-800 bg-white cursor-pointer hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 text-center inline-flex items-center space-x-2 border border-slate-300"
                    type="button">
                    <i class='bx bx-paper-plane text-xl'></i>
                    <span>Share</span>
                </button>

                <!-- Main modal -->
                <div id="default-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden bg-slate-500/40 fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow-sm ">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    How would you like to share your Campaign?
                                </h3>
                                <button type="button"
                                    class="text-gray-400 cursor-pointer bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
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
                            <div class="p-4 md:p-5 space-y-4">
                                <div class="mx-auto max-w-xl" x-data="{ showTab: null }">
                                    <section x-show="showTab == null" style="display: none;">
                                        <div class="grid md:grid-cols-3 gap-5 mb-5">
                                            <div @click="showTab = 'email'"
                                                class="bg-gray-50 border-2 border-gray-300 rounded-md hover:shadow-md hover:border-slate-900 hover: hover:bg-gray-100 p-3 transition duration-500 cursor-pointer ease-in-out">

                                                <div class="bg-slate-900 w-full mb-5">
                                                    <img src="{{ asset('images/video-thumbnail.jpg') }}" alt=""
                                                        class="w-full object-center object-cover">
                                                </div>
                                                <p class="text-center text-sm font-semibold">
                                                    Send via email
                                                </p>
                                            </div>
                                            <div @click="showTab = 'embed'"
                                                class="bg-gray-50 border-2 border-gray-300 rounded-md hover:shadow-md hover:border-slate-900 hover: hover:bg-gray-100 p-3 transition duration-500 cursor-pointer ease-in-out">

                                                <div class="bg-slate-900 w-full mb-5">
                                                    <img src="{{ asset('images/video-thumbnail.jpg') }}" alt=""
                                                        class="w-full object-center object-cover">
                                                </div>
                                                <p class="text-center text-sm font-semibold">
                                                    Copy embed code
                                                </p>
                                            </div>
                                            <div @click="showTab = 'social_share'"
                                                class="bg-gray-50 border-2 border-gray-300 rounded-md hover:shadow-md hover:border-slate-900 hover: hover:bg-gray-100 p-3 transition duration-500 cursor-pointer ease-in-out">

                                                <div class="bg-slate-900 w-full mb-5">
                                                    <img src="{{ asset('images/video-thumbnail.jpg') }}"
                                                        alt="" class="w-full object-center object-cover">
                                                </div>
                                                <p class="text-center text-sm font-semibold">
                                                    Social Share
                                                </p>
                                            </div>

                                        </div>

                                        <div class="w-full max-w-md">
                                            <div class="mb-2 flex justify-between items-center">
                                                <label for="campaign-url"
                                                    class="text-sm font-medium text-gray-900">Campaign link:</label>
                                            </div>
                                            <div class="flex items-center">
                                                <span
                                                    class="shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg ">URL</span>
                                                <div class="relative w-full">
                                                    <input id="campaign-url" type="text"
                                                        aria-describedby="helper-text-explanation"
                                                        class="bg-gray-50 border border-e-0 border-gray-300 text-gray-500  text-sm border-s-0 focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5 "
                                                        value="{{ route('campaign.view', ['uuid' => $campaign->uuid]) }}"
                                                        readonly disabled />
                                                </div>
                                                <button data-tooltip-target="tooltip-campaign-url"
                                                    data-copy-to-clipboard-target="campaign-url"
                                                    class="shrink-0 z-10 cursor-pointer inline-flex items-center py-3 px-4 text-sm font-medium text-center text-white bg-slate-700 rounded-e-lg hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 border border-slate-700  hover:border-slate-800 "
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
                                            <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 ">
                                                Copy link</p>
                                        </div>
                                    </section>

                                    <section x-show="showTab != null" style="display: none;" class="">
                                        <div class="mb-5">
                                            <button @click="showTab = null "
                                                class="cursor-pointer text-md font-semibold">
                                                < Back</button>
                                        </div>
                                        <div x-show="showTab == 'email'" style="display: none;">
                                            <form action="" class="space-y-3 mx-auto max-w-md mb-8">
                                                <div>
                                                    <label for="">Name</label>
                                                    <input type="text" name="name" placeholder="Name"
                                                        wire:model="name"
                                                        class="text-gray-400 form-control text-md w-full">
                                                </div>
                                                <div>
                                                    <label for="">Email <span
                                                            class="text-red-500">*</span></label>
                                                    <input type="email" name="email" placeholder="Email*"
                                                        wire:model="email"
                                                        class="text-gray-400 form-control text-md w-full">
                                                </div>
                                                <button type="button" wire:loading.attr="disabled"
                                                    wire:target="inviteUser" class="btn cursor-pointer"
                                                    wire:click="inviteUser">
                                                    <span wire:loading.remove wire:target="inviteUser">send</span>

                                                    <span wire:loading wire:target="inviteUser">Loading ...</span>
                                                </button>

                                            </form>
                                        </div>
                                        <div x-show="showTab == 'embed'" style="display: none;">
                                            <div class="w-full max-w-lg mx-auto">
                                                <div class="mb-2 flex justify-between items-center">
                                                    <p class="text-sm font-medium text-gray-900 ">Embed your
                                                        Campaign anywhere in your website:</p>
                                                </div>
                                                <div class="relative bg-gray-100 rounded-lg  p-4 h-28 shadow-lg">
                                                    <div class="overflow-auto max-h-full">
                                                        <pre><code id="code-block" class="text-sm text-gray-700  whitespace-pre">&#x3C;iframe src="{{ route('campaign.view', ['uuid' => $this->campaign->uuid]) }}" allow="camera *; microphone *; autoplay *; encrypted-media *; fullscreen *; display-capture *;" width="100%" height="600px" style="border: none; border-radius: 24px"&#x3E;&#x3C;/iframe&#x3E;
                                                            </code>
                                                        </pre>
                                                    </div>
                                                    <div class="absolute top-2 end-2 bg-gray-100 ">
                                                        <button data-copy-to-clipboard-target="code-block"
                                                            data-copy-to-clipboard-content-type="innerHTML"
                                                            data-copy-to-clipboard-html-entities="true"
                                                            class="text-gray-900 cursor-pointer m-0.5 hover:bg-gray-100  rounded-lg py-2 px-2.5 inline-flex items-center justify-center bg-white border-gray-200 border h-8">
                                                            <span id="default-message">
                                                                <span class="inline-flex items-center">
                                                                    <svg class="w-3 h-3 me-1.5" aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="currentColor" viewBox="0 0 18 20">
                                                                        <path
                                                                            d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                                                    </svg>
                                                                    <span class="text-xs font-semibold">Copy
                                                                        code</span>
                                                                </span>
                                                            </span>
                                                            <span id="success-message" class="hidden">
                                                                <span class="inline-flex items-center">
                                                                    <svg class="w-3 h-3 text-blue-700  me-1.5"
                                                                        aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 16 12">
                                                                        <path stroke="currentColor"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M1 5.917 5.724 10.5 15 1.5" />
                                                                    </svg>
                                                                    <span
                                                                        class="text-xs font-semibold text-blue-700 ">Copied</span>
                                                                </span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <p class="mt-2 text-sm text-gray-500">Copy Code</p>
                                            </div>
                                        </div>
                                        <div x-show="showTab == 'social_share'" style="display: none;">
                                            <p class="text-xl font-semibold">Social share</p>
                                            {{-- <div id="social-links" class="mt-4 mx-auto max-w-lg ">
                                                <ul class="flex gap-4 items-center bg-red-500">
                                                    <li>
                                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('campaign.view', ['uuid' => $this->campaign->uuid]) }}"
                                                            class="text-blue-600 hover:text-blue-800 text-2xl"
                                                            target="_blank" title="Share on Facebook">
                                                            <span class="fab fa-facebook-square"></span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://twitter.com/intent/tweet?text=Share+title&url={{ route('campaign.view', ['uuid' => $this->campaign->uuid]) }}"
                                                            class="text-blue-400 hover:text-blue-600 text-2xl"
                                                            target="_blank" title="Share on Twitter">
                                                            <span class="fab fa-twitter"></span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url={{ route('campaign.view', ['uuid' => $this->campaign->uuid]) }}&title=Share+title&summary=Extra+linkedin+summary+can+be+passed+here"
                                                            class="text-blue-700 hover:text-blue-900 text-2xl"
                                                            target="_blank" title="Share on LinkedIn">
                                                            <span class="fab fa-linkedin"></span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://wa.me/?text={{ route('campaign.view', ['uuid' => $this->campaign->uuid]) }}"
                                                            class="text-green-500 hover:text-green-700 text-2xl"
                                                            target="_blank" title="Share on WhatsApp">
                                                            <span class="fab fa-whatsapp"></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div> --}}

                                            <div id="social-links" class="mt-4">
                                                <ul class="grid grid-cols-2  gap-2 items-start sm:items-center">
                                                    <li
                                                        class="flex items-center gap-2 border-2 border-gray-300 rounded-md bg-gray-100 shadow-md hover:bg-gray-200 hover:border-slate-900 transition duration-500 ease-in-out">
                                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('campaign.view', ['uuid' => $this->campaign->uuid]) }}"
                                                            class="flex items-center gap-2 text-blue-600 hover:text-blue-800 text-lg w-full py-2 px-4"
                                                            target="_blank" title="Share on Facebook">
                                                            <span class="fab fa-facebook-square text-2xl"></span>
                                                            <div>
                                                                <p class="font-semibold">Facebook</p>
                                                                <p class="text-sm text-gray-500">Share on Facebook</p>
                                                            </div>
                                                        </a>
                                                    </li>

                                                    <li
                                                        class="flex items-center gap-2 border-2 border-gray-300 rounded-md bg-gray-100 shadow-md hover:bg-gray-200 hover:border-slate-900 transition duration-500 ease-in-out">
                                                        <a href="https://twitter.com/intent/tweet?text=Share+title&url={{ route('campaign.view', ['uuid' => $this->campaign->uuid]) }}"
                                                            class="flex items-center gap-2 text-slate-800 hover:text-slate-900 text-lg w-full py-2 px-4"
                                                            target="_blank" title="Share on Twitter">
                                                            <span class="fab fa-x-twitter text-2xl"></span>
                                                            <!-- Font Awesome uses fa-x-twitter -->
                                                            <div>
                                                                <p class="font-semibold">X</p>
                                                                <p class="text-sm text-gray-500">Share on Twitter</p>
                                                            </div>
                                                        </a>
                                                    </li>

                                                    <li
                                                        class="flex items-center gap-2 border-2 border-gray-300 rounded-md bg-gray-100 shadow-md hover:bg-gray-200 hover:border-slate-900 transition duration-500 ease-in-out">
                                                        <a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url={{ route('campaign.view', ['uuid' => $this->campaign->uuid]) }}&title=Share+title&summary=Extra+linkedin+summary+can+be+passed+here"
                                                            class="flex items-center gap-2 text-blue-700 hover:text-blue-900 text-lg w-full py-2 px-4"
                                                            target="_blank" title="Share on LinkedIn">
                                                            <span class="fab fa-linkedin text-2xl"></span>
                                                            <div>
                                                                <p class="font-semibold">LinkedIn</p>
                                                                <p class="text-sm text-gray-500">Share on LinkedIn</p>
                                                            </div>
                                                        </a>
                                                    </li>

                                                    <li
                                                        class="flex items-center gap-2 border-2 border-gray-300 rounded-md bg-gray-100 shadow-md hover:bg-gray-200 hover:border-slate-900 transition duration-500 ease-in-out">
                                                        <a href="https://wa.me/?text={{ route('campaign.view', ['uuid' => $this->campaign->uuid]) }}"
                                                            class="flex items-center gap-2 text-green-500 hover:text-green-700 text-lg w-full py-2 px-4"
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
                            <!-- Modal footer -->

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>




    <div class="flex gap-3 flex-wrap" id="zoomContainer" style="zoom: 0.9;">
        @php
            $lastPosition = $steps->max('id');
            $firstPosition = $steps->min('id');
        @endphp

        @forelse ($steps->sortBy('position') as $step)
            {{-- @forelse ($steps->sortBy('position') as $index => $step) --}}
            <div class="w-52 h-48 flex relative ">
                <div @click="editStep = true" wire:click="setStep({{ $step->id }}, {{ $step->position }})"
                    class=" cursor-pointer shadow-xl rounded-l-lg border-3 border-gray-300 w-[75%]   bg-white hover:shadow-sm transition duration-500 ease-in-out overflow-hidden">
                    <div
                        class="bg-white text-sm text-gray-800 font-bold py-1 px-2 truncate capitalize flex justify-between ">
                        <span>{{ $step->name }} </span>
                        <span class="rounded-full bg-gray-800 text-white px-2.5 py-1 text-center text-xs">
                            {{ $step->position }}
                        </span>
                    </div>
                    <div class="h-full  grid grid-cols-2">
                        <div class="bg-slate-200 h-full flex justify-center items-center">
                            <img src="{{ asset('images/video-thumbnail.jpg') }}" alt="video thumbnail"
                                class="w-full h-full object-center object-cover">
                        </div>
                        <div class="bg-slate-100 h-full"></div>

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
                            @if ($step->id != $firstPosition && $step->id != optional($lastStep)->id)
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
                @if ($step->id < $lastPosition)
                    <div class="w-[10%] flex items-center pl-2">
                        <span>


                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
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

                <div class="grid lg:grid-cols-3 h-full">
                    <div class="h-full lg:col-span-2 flex justify-center items-center">

                        @if (optional($activeStep)->id == optional($lastStep)->id)

                            <div class="h-[70%] w-[70%]  rounded-2xl overflow-hidden "
                                wire:key="display-{{ now() }}">
                                <div class="h-full w-full bg-red-500">
                                    <img src="{{ optional($activeStep)->last_cover_image }}"
                                        alt="" class="object-cover object-center w-full h-full">
                                </div>
                            </div>
                        @else
                            <div class="h-[70%] w-[70%]  rounded-2xl overflow-hidden grid grid-cols-2"
                                wire:key="display-{{ now() }}">
                                <div class="h-full bg-slate-600">
                                    @if ($activeStep)
                                        <video width="100%" controls class="mx-auto bg-slate-50 ">
                                            <source src="{{ $activeStep->video_url }}" type="video/webm">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </div>


                                <div class="h-full bg-white"></div>
                            </div>
                        @endif


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
                                @if (optional($activeStep)->id != optional($lastStep)->id)
                                    @if ($activeTab === 'video')
                                        <div class="">
                                            <livewire:video-setup :activeStep="$activeStep"
                                                wire:key="video-setup-{{ now() }}" />
                                        </div>
                                    @endif
                                    @if ($activeTab === 'answer')
                                        <div class="space-y-10">
                                            <div>
                                                <label for="answer_type" class="text-sm font-bold mb-1">Select
                                                    answer
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
                                                @if ($answer_type == 'payment')
                                                    <div>
                                                        <livewire:payment-component :activeStep="$activeStep" :campaign="$campaign"
                                                            wire:key="payment-{{ now() }}" />
                                                    </div>
                                                @endif
                                                @if ($answer_type == 'file_upload')
                                                    <div>
                                                        <livewire:file-upload :activeStep="$activeStep"
                                                            wire:key="file-{{ now() }}" />
                                                    </div>
                                                @endif
                                                @if ($answer_type == 'NPS')
                                                    <div>
                                                        <livewire:n-p-s-component :activeStep="$activeStep"
                                                            wire:key="file-{{ now() }}" />
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    @if ($activeTab === 'logic')
                                        <div class="">
                                            <livewire:logic-component :activeStep="$activeStep" :campaign="$campaign"
                                                wire:key="multi-choice-{{ now() }}" />
                                        </div>
                                    @endif
                                @else
                                    <x-session-msg />

                                    <div>

                                        {{-- <div class="container" style="width:364px;">

                                            <input type="file" class="filepond" name="file" />

                                        </div> --}}
                                        <div class="relative">
                                            <label title="Click to upload" for="button2"
                                                class="cursor-pointer flex items-center gap-4 px-6 py-4 before:border-gray-400/60 hover:before:border-gray-300 group before:bg-gray-100 before:absolute before:inset-0 before:rounded-3xl before:border before:border-dashed before:transition-transform before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95">
                                                <div class="w-max relative">
                                                    <img class="w-12"
                                                        src="https://www.svgrepo.com/show/485545/upload-cicle.svg"
                                                        alt="file upload icon" width="512" height="512">
                                                </div>
                                                <div class="relative">
                                                    <span
                                                        class="block text-base font-semibold relative text-blue-900 group-hover:text-blue-500">
                                                        Upload a file
                                                    </span>
                                                    <span class="mt-0.5 block text-sm text-gray-500">Max 2 MB</span>
                                                </div>
                                            </label>
                                            <input type="file" wire:model="thank_you_image" id="button2"
                                                class="hidden">
                                        </div>

                                        <div class=" max-w-sm my-5">
                                            {{-- <button class="cursor-pointer btn" wire:click="saveCoverImage()">Upload</button> --}}
                                            <button class="btn cursor-pointer" wire:loading.attr="disabled"
                                                wire:target="saveCoverImage" wire:click="saveCoverImage()">
                                                <span wire:loading.remove wire:target="saveCoverImage">Upload</span>
                                                <span wire:loading wire:target="saveCoverImage" class="">
                                                    Loading...
                                                </span>
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




    {{-- <input type="file" class="filepond" name="file" />

    <script>
        FilePond.create(document.querySelector('.filepond'));
    </script> --}}









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
                    clientAllowedFormats: ["mp4", "avi", "mov", "webm"],
                    maxFileSize: 500000000
                }, (error, result) => {
                    if (!error && result && result.event === "success") {
                        // console.log("Done! Here is the image info: ", result.info);
                        let response = result.info;

                        Livewire.dispatch('update-video', {
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
        </script>
    @endsection
</div>
