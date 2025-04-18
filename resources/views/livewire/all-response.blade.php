<div>

    <section class="grid lg:grid-cols-7 gap-5 px-5" x-data="{ activeResponse: null }">
        <div class="lg:col-span-2 ">
            <div class="relative mb-3" x-data="{ openDrawer: false }">
                <div class="flex justify-end">
                    <button @click="openDrawer = true"
                        class="rounded-md px-4 py-2 bg-gray-200 hover:bg-white shadow border border-gray-300 bg-white cursor-pointer">
                        <i class='bx bx-slider text-xl'></i>
                    </button>
                </div>
                <div x-show="openDrawer" @click.away="openDrawer = false" style="display: none"
                    class="absolute z-10 right-0 top-0 bg-gray-50 shadow-xl p-3 rounded-md space-y-1">
                    <div class="flex justify-between items-center mb-3">
                        <h5 class="font-semibold ">Filter By:</h5>
                        <button @click="openDrawer = false" class="cursor-pointer">
                            <i class='bx bx-x-circle hover:text-black'></i>
                        </button>
                    </div>
                    <div
                        class="bg-gray-50 border border-gray-300 bg-white rounded-lg block w-full px-2 py-1.5  items-center flex justify-between">
                        <h5 class="font-semibold text-gray-900 text-sm">Has Email</h5>
                        <label class="relative inline-flex items-center  cursor-pointer">
                            <input type="checkbox" value="1" class="sr-only peer" wire:model.live="filterEmail">
                            <div
                                class="w-11 z-0 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-400  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-green-400">
                            </div>
                        </label>
                    </div>
                    <div
                        class="bg-gray-50 border border-gray-300 bg-white rounded-lg block w-full px-2 py-1.5  items-center flex justify-between">
                        <h5 class="font-semibold text-gray-900 text-sm">Has Video</h5>
                        <label class="relative inline-flex items-center  cursor-pointer">
                            <input type="checkbox" value="1" class="sr-only peer" wire:model.live="filterVideo">
                            <div
                                class="w-11 z-0 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-400  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-green-400">
                            </div>
                        </label>
                    </div>
                    <div
                        class="bg-gray-50 border border-gray-300 bg-white rounded-lg block w-full px-2 py-1.5  items-center flex justify-between">
                        <h5 class="font-semibold text-gray-900 text-sm">Has Text</h5>
                        <label class="relative inline-flex items-center  cursor-pointer">
                            <input type="checkbox" value="1" class="sr-only peer" wire:model.live="filterText">
                            <div
                                class="w-11 z-0 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-400  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-green-400">
                            </div>
                        </label>
                    </div>
                    <div
                        class="bg-gray-50 border border-gray-300 bg-white rounded-lg block w-full px-2 py-1.5  items-center flex justify-between">
                        <h5 class="font-semibold text-gray-900 text-sm">Has Audio</h5>
                        <label class="relative inline-flex items-center  cursor-pointer">
                            <input type="checkbox" value="1" class="sr-only peer" wire:model.live="filterAudio">
                            <div
                                class="w-11 z-0 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-400  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-green-400">
                            </div>
                        </label>
                    </div>
                    <div
                        class="bg-gray-50 border border-gray-300 bg-white rounded-lg block w-full px-2 py-1.5  items-center flex justify-between">
                        <h5 class="font-semibold text-gray-900 text-sm">Has NPS Score</h5>
                        <label class="relative inline-flex items-center  cursor-pointer">
                            <input type="checkbox" value="1" class="sr-only peer" wire:model.live="filterNps">
                            <div
                                class="w-11 z-0 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-400  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-green-400">
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="max-w-sm mx-auto">
                <div x-data="{ openDelete: false }" class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <ul class="divide-y divide-gray-200 h-48 lg:h-[550px] overflow-y-scroll">
                        @forelse ($responses as $key =>  $response)
                            <li class="p-3 flex justify-between items-center user-card hover:shadow-2xl transition duration-500 border-2 ease-in-out rounded-md {{ $activeResponse->id == $response->id ? 'border-slate-500 shadow-2xl' : 'border-transparent' }}" ">
                                <div class="flex items-center w-[100%] cursor-pointer"
                                    @click="activeResponse = @js($response)"
                                    wire:click="setResponse('{{ $response->user_token }}')">
                                    <img class="w-10 h-10 rounded-full"
                                        src="https://unsplash.com/photos/oh0DITWoHi4/download?force=true&w=640"
                                        alt="Christy">
                                    <div>
                                        <p class="ml-3 font-medium  capitalize truncate">
                                            {{-- {{ $response->name }} --}}
                                            {{ $response->name ?? '' }}
                                        </p>
                                        <span class="ml-3 font-medium truncate text-xs text-gray-500">
                                            {{ $response->email ?? '' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex space-x-1">
                                    <button @click="openDelete = true " wire:click="setActiveResponse('{{ $response->user_token }}')" class="text-gray-500 hover:text-gray-700 cursor-pointer ">
                                        <i class='bx bxs-trash-alt text-xl text-red-500 hover:text-red-700' ></i>
                            </button>
                </div>
                </li>
            @empty
                @endforelse
                </ul>

                {{-- openDelete --}}
                <div class="fixed items-center justify-center  flex top-0 left-0 mx-auto w-full h-full bg-gray-500/30 z-50 transition duration-1000 ease-in-out"
                    x-show="openDelete" style="display: none;">
                    <div @click.away="openDelete = false"
                        class="bg-white w-[90%] md:w-[40%]  shadow-inner  border rounded-2xl overflow-auto  py-6 px-8 transition-all relative duration-700">
                        <div class=" h-full ">


                            <div class="my-10 space-y-3">

                                <h5 class="text-center text-2xl font-semibold pb-1">All response data will be
                                    deleted!
                                </h5>
                                <p class="text-center text-md font-medium pb-3">Are you Sure?</p>

                                <div class="flex justify-center space-x-2">
                                    <div>
                                        <button type="button" @click="openDelete = false" wire:click="deleteResponsesByToken()"
                                            class="btn-danger cursor-pointer">
                                            Yes, Delete
                                        </button>
                                    </div>
                                    <div>
                                        <button type="button" @click="openDelete = false" class="btn2 cursor-pointer">
                                            No, Cancle
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>


<div x-data="{ openResponseOptions: false, openResponse: null }" class="lg:col-span-5  lg:h-[550px] bg-slate-100 rounded-lg overflow-hidden shadow-xl "
    wire:key="active-{{ now() }}">
    @php
        // $individualResponses = $responsesByToken[optional($activeResponse)->user_token] ?? collect();
        $individualResponses = ($responsesByToken[optional($activeResponse)->user_token] ?? collect())->sortBy('id');
    @endphp
    @if (!empty($activeResponse))
        <div class="relative h-full flex" x-data="responseRecorder()">
            <div class="w-[85%]">
                @if (optional($activeResponse)->video ||
                        optional($activeResponse)->file_upload ||
                        optional($activeResponse)->multi_option_response ||
                        optional($activeResponse)->nps_score)
                    <div class="relative h-full ">
                        @foreach ($individualResponses as $index => $res)
                            @if ($index == $activeIndex)
                                <div class="absolute top-0 w-full p-5 space-y-5 flex flex-col  items-end ">
                                    <div class="space-y-1 lg:flex flex-col  items-end hidden">
                                        <h5 class="font-bold text-green-500">{{ $res->name }}</h5>
                                        <p class="font-semibold text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($res->created_at)->format('F j, Y') }}</p>
                                        <p class="font-semibold text-sm text-green-500">{{ $res->email }}</p>
                                        <p class="font-semibold text-sm text-gray-500">{{ $res->phonenumber }}</p>
                                        <p class="font-semibold text-sm text-gray-500">{{ $res->productname }}</p>
                                        <p class="font-semibold ">
                                            {{-- @if ($res->consent)
                                                <i class='bx bxs-message-square-check text-xl text-green-500'
                                                    title="consent accepted"></i>
                                            @else
                                                <i class='bx bxs-message-square-x text-xl text-red-500'
                                                    title="consent  not accepted"></i>
                                            @endif --}}
                                        </p>
                                    </div>

                                    <div>
                                        <button @click="openResponseOptions = true, openResponse = null"
                                            class="cursor-pointer relative z-10 text-white bg-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm p-2 lg:px-5 lg:py-2.5 text-center inline-flex items-center lg:space-x-4 border ">
                                            <span><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                                </svg>
                                            </span>
                                            <span class="hidden lg:flex">Reply</span>
                                        </button>
                                    </div>
                                </div>
                                {{-- {{ $activeIndex }} --}}
                                {{-- <video controls class="mx-auto bg-slate-50/10 max-w-full  object-contain">
                                        <source src="{{ optional($activeResponse)->video }}" type="video/webm">
                                    </video> --}}

                                @if (!empty($res->video))
                                    <div>
                                        <video controls class="mx-auto bg-slate-50/10 max-w-full w-full  object-cover">
                                            <source src="{{ optional($activeResponse)->video }}" type="video/webm">
                                        </video>
                                    </div>
                                @elseif (!empty($res->audio))
                                    <div class="h-full flex justify-center items-center p-2 lg:p-10 bg-black/50">
                                        <audio controls class="mx-auto w-full">
                                            <source src="{{ $res->audio }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                @elseif (!empty($res->text))
                                    <div class="p-5">
                                        <div class="flex items-ceter space-x-3">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                                </svg>
                                            </span>
                                            <span
                                                class="font-medium text-md capitalize max-w-sm">{{ $res->text }}</span>
                                        </div>
                                    </div>
                                @elseif (!empty($res->file_upload))
                                    <div
                                        class="h-full flex flex-col justify-center items-center p-2 lg:p-10 bg-black/50 gap-4 ">
                                        @php
                                            $file = $res->file_upload;
                                            $extension = pathinfo($file, PATHINFO_EXTENSION);
                                        @endphp

                                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                            <img src="{{ $file }}" alt="Preview"
                                                class="max-w-full max-h-64 rounded shadow">
                                        @elseif(in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                            <video src="{{ $file }}" controls
                                                class="max-w-full max-h-64 rounded shadow"></video>
                                        @elseif(strtolower($extension) === 'pdf')
                                            <iframe src="{{ $file }}" class="w-full h-[70%] rounded shadow "
                                                frameborder="0"></iframe>
                                        @elseif(in_array($extension, ['doc', 'docx', 'zip', 'csv', 'txt']))
                                            {{-- Show icon based on type --}}
                                            <div class="text-center">
                                                @if (in_array($extension, ['doc', 'docx']))
                                                    <span>📄 Word Document</span>
                                                @elseif($extension === 'zip')
                                                    <span>🗜️ ZIP Archive</span>
                                                @elseif($extension === 'csv')
                                                    <span>📊 CSV File</span>
                                                @elseif($extension === 'txt')
                                                    <span>📃 Text File</span>
                                                @endif
                                            </div>
                                        @else
                                            <p class="text-white">Preview not available for this file type.</p>
                                        @endif

                                        <a href="{{ $file }}" download target="_blank"
                                            class="mt-2 px-4 py-2 bg-white text-black rounded hover:bg-gray-200 transition">
                                            Download File
                                        </a>
                                    </div>
                                @elseif (!empty($res->multi_option_response))
                                    <div class="h-full flex flex-col justify-center items-center p-2 lg:p-10  ">

                                        <ul class=" space-y-3 w-full lg:w-[50%]">
                                            @foreach (json_decode($res->multi_option_response, true) as $option)
                                                <li
                                                    class="flex items-center space-x-2 border-b-2 border-gray-300 py-2">
                                                    <span><i class='bx bxs-check-circle'></i></span>
                                                    <span class="text-xl">{{ $option }}</span>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </div>
                                @elseif (!empty($res->nps_score))
                                    <div class="h-full flex flex-col justify-center items-center p-2 lg:p-10  ">

                                        <div x-data="{ NPS: {{ $res->nps_score }} }"
                                            class="bg-white rounded-lg shadow  flex items-center justify-center space-x-10 py-3 px-3">
                                            <div class="space-y-3">

                                                <div class="flex space-x-2">
                                                    <label for="nps-1"
                                                        class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                                                        :class="{ 'text-yellow-400 bg-gray-900': NPS >= 1 }">
                                                        <span>1</span>
                                                        <input type="radio" class="hidden" value="1"
                                                            id="nps-1">
                                                    </label>
                                                    <label for="nps-2"
                                                        class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                                                        :class="{ 'text-yellow-400 bg-gray-900': NPS >= 2 }">
                                                        <span>2</span>
                                                        <input type="radio" class="hidden" value="2"
                                                            id="nps-2">
                                                    </label>
                                                    <label for="nps-3"
                                                        class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                                                        :class="{ 'text-yellow-400 bg-gray-900': NPS >= 3 }">
                                                        <span>3</span>
                                                        <input type="radio" class="hidden" value="3"
                                                            id="nps-3">
                                                    </label>
                                                    <label for="nps-4"
                                                        class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                                                        :class="{ 'text-yellow-400 bg-gray-900': NPS >= 4 }">
                                                        <span>4</span>
                                                        <input type="radio" class="hidden" value="4"
                                                            id="nps-4">
                                                    </label>
                                                    <label for="nps-5"
                                                        class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                                                        :class="{ 'text-yellow-400 bg-gray-900': NPS >= 5 }">
                                                        <span>5</span>
                                                        <input type="radio" class="hidden" value="5"
                                                            id="nps-5">
                                                    </label>
                                                    <label for="nps-6"
                                                        class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                                                        :class="{ 'text-yellow-400 bg-gray-900': NPS >= 6 }">
                                                        <span>6</span>
                                                        <input type="radio" class="hidden" value="6"
                                                            id="nps-6">
                                                    </label>
                                                    <label for="nps-7"
                                                        class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                                                        :class="{ 'text-yellow-400 bg-gray-900': NPS >= 7 }">
                                                        <span>7</span>
                                                        <input type="radio" class="hidden" value="7"
                                                            id="nps-7">
                                                    </label>
                                                    <label for="nps-8"
                                                        class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                                                        :class="{ 'text-yellow-400 bg-gray-900': NPS >= 8 }">
                                                        <span>8</span>
                                                        <input type="radio" class="hidden" value="8"
                                                            id="nps-8">
                                                    </label>
                                                    <label for="nps-9"
                                                        class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                                                        :class="{ 'text-yellow-400 bg-gray-900': NPS >= 9 }">
                                                        <span>9</span>
                                                        <input type="radio" class="hidden" value="9"
                                                            id="nps-9">
                                                    </label>
                                                    <label for="nps-10"
                                                        class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                                                        :class="{ 'text-yellow-400 bg-gray-900': NPS >= 10 }">
                                                        <span>10</span>
                                                        <input type="radio" class="hidden" value="10"
                                                            id="nps-10">
                                                    </label>
                                                </div>


                                                <div class="flex justify-between">
                                                    <span class="text-xs text-gray-500 ">very unlikely</span>
                                                    <span class="text-xs text-gray-500 ">very likely</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                                {{-- <div>
                                        {{ $index }}
                                    </div> --}}
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>




            <div class="w-[15%] h-80 md:h-full lg:h-full bg-black/60">
                <div class="overflow-y-auto space-y-1 h-full p-0.5 lg:p-3">
                    @foreach ($individualResponses as $index => $res)
                        @if (
                            !empty($res->text) ||
                                !empty($res->audio) ||
                                !empty($res->video) ||
                                !empty($res->file_upload) ||
                                !empty($res->multi_option_response) ||
                                !empty($res->nps_score))
                            <button wire:click="showResponse({{ $index }})"
                                class=" text-sm border {{ $res->type == 'creator' ? 'border-red-500 text-red-500' : '' }}  cursor-pointer rounded-md bg-white p-1 col-span-1 w-full h-16 flex justify-center items-center focus:ring-2 focus:outline-none focus:ring-gray-300">
                                @if (!empty($res->video))
                                    <i class='bx bxs-videos text-3xl'></i>
                                @elseif (!empty($res->audio))
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                                    </svg>
                                @elseif (!empty($res->text))
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                    </svg>
                                @elseif (!empty($res->file_upload))
                                    <i class='bx bx-file text-3xl'></i>
                                @elseif (!empty($res->multi_option_response))
                                    <i class='bx bx-menu text-3xl'></i>
                                @elseif (!empty($res->nps_score))
                                    <span class="lg:text-xl font-bold">NPS</span>
                                @endif
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>


            <section x-show="openResponseOptions" style="display: none;"
                class="absolute bottom-0 w-[85%] bg-black/50 h-full p-5 flex justify-center items-center">

                <div x-show="openResponse == null" class="">
                    <h1 class="text-xl font-semibold text-center mb-4 text-gray-50">Pick an option</h1>
                    <div class="flex justify-center space-x-2 " @click.away="openResponseOptions = false">
                        <button @click="openResponse = 'audio' "
                            class=" rounded-full lg:rounded-md bg-blue-100 p-2 lg:py-5 lg:px-10 text-[#0F1523] cursor-pointer hover:opacity-90 hover:shadow-xl transition duration-500 ease-in-out focus:ring-4 focus:outline-none focus:ring-gray-50">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                                </svg>
                            </span>
                        </button>

                        <button @click="openResponse = 'video' "
                            class=" rounded-full lg:rounded-md bg-blue-100 p-2 lg:py-5 lg:px-10 text-[#0F1523] cursor-pointer hover:opacity-90 hover:shadow-xl transition duration-500 ease-in-out focus:ring-4 focus:outline-none focus:ring-gray-50">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </span>
                        </button>

                        <button @click="openResponse = 'text' "
                            class=" rounded-full lg:rounded-md bg-blue-100 p-2 lg:py-5 lg:px-10 text-[#0F1523] cursor-pointer hover:opacity-90 hover:shadow-xl transition duration-500 ease-in-out focus:ring-4 focus:outline-none focus:ring-gray-50">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                </svg>
                            </span>
                        </button>

                    </div>
                </div>

            </section>



            <div x-show="openResponse != null" style="display: none;"
                class="bg-slate-300 w-full h-full absolute z-10 p-2 lg:p-10 flex  items-center"
                @click.away="openResponseOptions = false, openResponse = null">
                <div x-show="openResponse == 'video'" style="display: none;" class="w-full">
                    <div>
                        <video x-ref="videoPlayer" autoplay muted controls class="w-full"></video>
                        <input type="file" wire:model="videoResponse" x-ref="videoUpload" class="hidden">
                        <div class="my-4" x-data="{ isPlaying: false }">
                            <button x-show="!isPlaying"
                                class="rounded-md px-4 flex items-center space-x-2 py-2 bg-white cursor-pointer hover:shadow-lg shadow-inner hover:bg-slate-800 hover:text-white transition duration-500 ease-in-out border bg-slate-300 border-slate-500"
                                @click="startVideoRecording(), isPlaying = true">
                                <i class='bx bx-play text-2xl'></i>
                                <span>Start Video</span>
                            </button>
                            <button x-show="isPlaying"
                                class="rounded-md px-4 flex items-center space-x-2 py-2 bg-white cursor-pointer hover:shadow-lg shadow-inner hover:bg-slate-800 hover:text-white transition duration-500 ease-in-out border bg-slate-300 border-slate-500"
                                @click="stopVideoRecording(), isPlaying = false">
                                <i class='bx bx-pause text-2xl'></i>
                                <span>Stop Video</span>
                            </button>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <button class="btn cursor-pointer" x-show="shouldContinue">
                            Continue
                        </button>
                    </div>
                </div>
                <div x-show="openResponse == 'audio'" class="w-full" style="display: none;">
                    <div>
                        <audio x-ref="audioPlayer" controls class="w-full"></audio>
                        <input type="file" wire:model="audioResponse" x-ref="videoUpload" class="hidden">
                        <div class="my-4" x-data="{ isPlaying: false }">
                            <button x-show="!isPlaying"
                                class="rounded-md px-4 flex items-center space-x-2 py-2 bg-white cursor-pointer hover:shadow-lg shadow-inner hover:bg-slate-800 hover:text-white transition duration-500 ease-in-out border bg-slate-300 border-slate-500"
                                @click="startAudioRecording(), isPlaying = true">
                                <i class='bx bx-play text-2xl'></i>
                                <span>Start Audio</span>
                            </button>
                            <button x-show="isPlaying"
                                class="rounded-md px-4 flex items-center space-x-2 py-2 bg-white cursor-pointer hover:shadow-lg shadow-inner hover:bg-slate-800 hover:text-white transition duration-500 ease-in-out border bg-slate-300 border-slate-500"
                                @click="stopAudioRecording(), isPlaying = false">
                                <i class='bx bx-pause text-2xl'></i>
                                <span>Stop Audio</span>
                            </button>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <button class="btn cursor-pointer" x-show="shouldContinue">
                            Finish
                        </button>
                    </div>
                </div>
                <div x-show="openResponse == 'text'" style="display: none;" class="w-full">
                    {{-- <textarea name="" id="" rows="10" class="w-full" placeholder="Enter text here"></textarea> --}}
                    <textarea id="textResponse" x-model="textResponse" wire:model="textResponse"
                        class="w-full p-3 bg-white rounded-md h-16 md:h-56" placeholder="Enter text here"
                        @input="shouldContinue = textResponse.trim() !== ''"></textarea>
                    <div class="flex space-x-3">

                        <button class="btn cursor-pointer" wire:click="saveText()">
                            Submit
                        </button>
                    </div>
                </div>
            </div>


        </div>
    @endif
</div>
</section>



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
                        this.$refs.videoPlayer.src = audioUrl;

                        const file = new File([audioBlob], `audio_${Date.now()}.webm`, {
                            type: 'audio/webm'
                        });

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

                        const file = new File([videoBlob], `video_${Date.now()}.webm`, {
                            type: 'video/webm'
                        });

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        this.$refs.videoUpload.files = dataTransfer.files;

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
                setTimeout(() => {
                    this.shouldContinue = true;
                }, 2000);

            }
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
</div>
