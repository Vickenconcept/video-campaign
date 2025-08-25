<div class=" h-screen overflow-y-auto px-5  pb-32 pt-5">
    <div wire:key="message-{{ now() }}">
        <x-session-msg />
    </div>

    @if (count($campaigns ?? []) > 0)
        <div class="space-y-8" x-data="{ openDelete: false, openFolder: false, editModal: false }">
            <!-- Enhanced Header Section -->
            <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-6 shadow-2xl shadow-gray-500/20 border border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                    <div>
                        <h3 class="font-bold text-3xl text-gray-900 mb-2">{{ $folder->name }}</h3>
                        <p class="text-gray-600">Manage your video funnels in this folder</p>
                    </div>
                    <div class="w-full md:w-auto">
                        <button class="w-full md:w-auto bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-medium py-3.5 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2" data-modal-target="create-modal" data-modal-toggle="create-modal">
                            <i class="bx bx-plus text-lg"></i>
                            <span>Create Video Funnel</span>
                        </button>
                    </div>
                </div>
            </div>

            @if (count($selectedCampaigns) > 0)
                <div class="bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-lg p-4 flex items-center justify-between">
                    <span class="text-red-700 font-medium">Selected {{ count($selectedCampaigns) }} campaign(s)</span>
                    <button wire:click="deleteSelected"
                        class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-2.5 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg font-medium">
                        Delete Selected
                    </button>
                </div>
            @endif

            <section wire:key="section-{{ now() }}">
                <ul class="grid lg:grid-cols-4 gap-6">
                    @forelse ($campaigns as $campaign)
                        <div class="relative group" x-data="{ isOpen: false }" wire:key="campaign-{{ $campaign->id }}">
                            <div class="relative hover:shadow-2xl shadow-lg transition-all duration-300 ease-in-out rounded-xl border border-gray-200 overflow-hidden bg-white hover:border-indigo-300">
                                <div class="bg-gray-500 h-40 overflow-hidden relative">
                                    <img src="{{ asset('images/video-thumbnail.jpg') }}" alt="video thumbnail"
                                    class="w-full h-full object-center object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute top-0 left-0 p-3 z-30 w-full @if (count($selectedCampaigns) > 0) @else hidden @endif group-hover:flex">
                                        <div class="flex items-center">
                                            <input id="checkbox1-{{ $campaign->id }}" type="checkbox"
                                                wire:change="toggleSelectCampaign({{ $campaign->id }})" class="hidden peer"
                                                {{ in_array($campaign->id, $selectedCampaigns) ? 'checked' : '' }} />
                                            <label for="checkbox1-{{ $campaign->id }}"
                                                class="relative flex items-center justify-center p-1 peer-checked:before:hidden before:block before:absolute before:w-full before:h-full before:bg-white w-6 h-6 cursor-pointer bg-indigo-500 border rounded overflow-hidden shadow-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-full fill-white"
                                                    viewBox="0 0 520 520">
                                                    <path
                                                        d="M79.423 240.755a47.529 47.529 0 0 0-36.737 77.522l120.73 147.894a43.136 43.136 0 0 0 36.066 16.009c14.654-.787 27.884-8.626 36.319-21.515L486.588 56.773a6.13 6.13 0 0 1 .128-.2c2.353-3.613 1.59-10.773-3.267-15.271a13.321 13.321 0 0 0-19.362 1.343q-.135.166-.278.327L210.887 328.736a10.961 10.961 0 0 1-15.585.843l-83.94-76.386a47.319 47.319 0 0 0-31.939-12.438z"
                                                        data-name="7-Check" data-original="#000000" />
                                                </svg>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 flex justify-between items-center">
                                    <div class="flex items-center w-[60%] cursor-pointer"
                                        @click="activeCampaign = @js($campaign)">
                                        <span class="font-semibold text-gray-900 capitalize truncate"
                                            title="{{ $campaign->title }}">{{ $campaign->title }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('campaign.show', ['uuid' => $campaign->uuid]) }}"
                                            class="bg-gradient-to-r from-blue-400 to-blue-500 hover:from-blue-500 hover:to-blue-600 text-white p-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>

                                        <button @click="isOpen = true"
                                            class="bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white p-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 12h16m-7 6h7" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Enhanced Dropdown menu -->
                            <div x-show="isOpen" style="display: none;" @click.away="isOpen = false"
                                class="absolute right-0 -bottom-2 z-20 bg-white divide-y divide-gray-100 rounded-xl shadow-xl w-48 overflow-hidden border border-gray-200">
                                <ul class="text-sm text-gray-700">
                                    <li>
                                        <button wire:click="duplicateCampaign({{ $campaign->id }})"
                                            class="cursor-pointer block w-full text-left px-4 py-3 hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                                            <div class="flex items-center gap-3">
                                                <i class='bx bx-copy text-lg text-indigo-500'></i>
                                                <span class="font-medium">Duplicate</span>
                                            </div>
                                        </button>
                                    </li>
                                    <li>
                                        <button @click="openDelete = true"
                                            wire:click="setCampaign({{ $campaign->id }})"
                                            class="cursor-pointer block w-full text-left px-4 py-3 hover:bg-red-50 hover:text-red-700 transition-colors duration-200">
                                            <div class="flex items-center gap-3">
                                                <i class='bx bx-trash text-lg text-red-500'></i>
                                                <span class="font-medium">Delete</span>
                                            </div>
                                        </button>
                                    </li>
                                    <li>
                                        <button @click="openFolder = true"
                                            wire:click="setCampaign({{ $campaign->id }})"
                                            class="cursor-pointer block w-full text-left px-4 py-3 hover:bg-green-50 hover:text-green-700 transition-colors duration-200">
                                            <div class="flex items-center gap-3">
                                                <i class='bx bx-folder text-lg text-green-500'></i>
                                                <span class="font-medium">Move To Folder</span>
                                            </div>
                                        </button>
                                    </li>
                                    <li>
                                        <button @click="editModal = true" wire:click="setCampaign({{ $campaign->id }})"
                                            class="cursor-pointer block w-full text-left px-4 py-3 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                                            <div class="flex items-center gap-3">
                                                <i class='bx bx-cog text-lg text-blue-500'></i>
                                                <span class="font-medium">Settings</span>
                                            </div>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </ul>
            </section>


            {{-- openDelete --}}
            <div class="fixed items-center justify-center  flex top-0 left-0 mx-auto w-full h-full bg-gray-500/30 z-50 transition duration-1000 ease-in-out"
                x-show="openDelete" style="display: none;">
                <div @click.away="openDelete = false"
                    class="bg-white w-[90%] md:w-[40%]  shadow-inner  border rounded-2xl overflow-auto  py-6 px-8 transition-all relative duration-700">
                    <div class=" h-full ">


                        <div class="my-10 space-y-3">

                            <h5 class="text-center text-2xl font-semibold pb-1">All campaign and response will be
                                deleted!
                            </h5>
                            <p class="text-center text-md font-medium pb-3">Are you Sure?</p>

                            <div class="flex justify-center space-x-2">
                                <div>
                                    <button type="button" @click="openDelete = false" wire:click="deleteCampaign()"
                                        class="btn-danger cursor-pointer">
                                        Yes, Delete
                                    </button>
                                </div>
                                <div>
                                    <button type="button" @click="openDelete = false" class="btn3 cursor-pointer">
                                        No, Cancle
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- openFolder --}}
            <div class="fixed items-center justify-center  flex top-0 left-0 mx-auto w-full h-full bg-gray-500/30 z-50 transition duration-1000 ease-in-out"
                x-show="openFolder" style="display: none;">
                <div @click.away="openFolder = false"
                    class="bg-white w-[90%] md:w-[40%]  shadow-inner  border rounded-2xl overflow-auto  py-6 px-8 transition-all relative duration-700">
                    <div class=" h-full ">


                        <div class="space-y-3 h-96 overflow-y-auto">

                            <h5 class="text-center text-2xl font-semibold pb-1">Move to folder
                            </h5>

                            @forelse ($all_folder as $folder)
                                <label wire:click="moveToFolder()" title="Move to this folder"
                                    class="block cursor-pointer border border-gray-300 px-4 py-3 bg-slate-100 rounded-lg shadow-sm hover:shadow-lg">
                                    <div class="space-x-2 flex items-center ">
                                        <span><i class='bx bxs-folder text-xl'></i></span>
                                        <span class="capitalize">{{ $folder->name }}</span>
                                    </div>
                                    <input type="radio" wire:model="selectedFolder" class="hidden"
                                        value="{{ $folder->id }}">
                                </label>
                            @empty
                            @endforelse


                        </div>
                    </div>
                </div>
            </div>


            {{-- editModal --}}
            <div class="fixed items-center justify-center  flex top-0 left-0 mx-auto w-full h-full bg-gray-500/30 z-50 transition duration-1000 ease-in-out"
                x-show="editModal" style="display: none;">
                <div @click.away="editModal = false"
                    class="bg-white w-[90%] md:w-[40%]  shadow-inner  border rounded-2xl overflow-auto  py-6 px-8 transition-all relative duration-700">
                    <div class=" h-full ">


                        <div class="space-y-3 h-auto overflow-y-auto">

                            <div class="flex justify-between items-center">
                                <h5 class="text-center text-2xl font-semibold pb-1">Edit campaign
                                </h5>

                                <button type="button"
                                    class="end-2.5 cursor-pointer text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
                                    @click="editModal = false">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>

                            <div class="space-y-4">
                                <div>

                                    <input type="text" wire:model="title" id="title" class="form-control "
                                        placeholder="Enter Campaign title" />
                                </div>


                                <div
                                    class="bg-gray-50 border border-gray-300 rounded-lg block w-full px-2.5 py-1  items-center flex justify-between">
                                    <h5 class="font-semibold">Language</h5>
                                    @php
                                        $languages = [
                                            'en' => 'English',
                                            'fr' => 'French',
                                            'es' => 'Spanish',
                                            'de' => 'German',
                                            'zh-CN' => 'Chinese',
                                            'ar' => 'Arabic',
                                            'hi' => 'Hindi',
                                        ];
                                    @endphp

                                    <select wire:model="language" id="language"
                                        class="bg-gray-300 text-gray-800 rounded-md p-2 font-medium">
                                        <option value="">Select Language</option>
                                        @foreach ($languages as $code => $name)
                                            <option class="bg-white text-gray-700  font-medium"
                                                value="{{ $code }}">
                                                {{ $name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <button @click="editModal = false" wire:click="editCampaign()" type="button"
                                    class="btn cursor-pointer">Edit
                                    Folder</button>

                            </div>


                        </div>
                    </div>
                </div>
            </div>


        </div>



    @endif

    @if (count($campaigns ?? []) == 0)
        <div class="h-[80%] flex justify-center items-center">
            <div class="max-w-md w-full text-center">
                <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-8 shadow-sm border border-gray-200">
                    <div class="mb-6">
                        <i class='bx bxs-folder-open text-6xl text-gray-400'></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">No campaigns yet</h3>
                    <p class="text-gray-500 mb-6">Get started by creating your first video funnel in this folder</p>
                    <button class="bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-medium py-3.5 px-8 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 mx-auto" data-modal-target="create-modal" data-modal-toggle="create-modal">
                        <i class="bx bx-plus text-lg"></i>
                        <span>Create Video Funnel</span>
                    </button>
                </div>
            </div>
        </div>
    @endif



    <!-- Main modal -->
    <div id="create-modal" tabindex="-1" aria-hidden="true" wire:ignore
        class="hidden overflow-y-auto bg-slate-500/40 overflow-x-hidden fixed top-10 h-screen right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow border">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                    <h3 class="text-xl font-semibold text-gray-900 ">
                        Okay, let's get started
                    </h3>

                    <button type="button"
                        class="end-2.5 cursor-pointer text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
                        data-modal-hide="create-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>


                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <div class="space-y-4">
                        <div>
                            {{-- <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Name
                             *</label> --}}
                            <input type="text" wire:model="title" id="title" class="form-control "
                                placeholder="Enter Campaign title" />
                        </div>

                        <div
                            class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5  items-center flex justify-between">
                            <h5 class="font-semibold">Collect contact details</h5>
                            <label class="relative inline-flex items-center  cursor-pointer">
                                <input type="checkbox" value="1" class="sr-only peer"
                                    wire:model="contact_detail">
                                <div
                                    class="w-11 z-0 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-400  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-indigo-400">
                                </div>
                            </label>
                        </div>
                        <div
                            class="bg-gray-50 border border-gray-300 rounded-lg block w-full px-2.5 py-1  items-center flex justify-between">
                            <h5 class="font-semibold">Language</h5>
                            @php
                                $languages = [
                                    'en' => 'English',
                                    'fr' => 'French',
                                    'es' => 'Spanish',
                                    'de' => 'German',
                                    'zh-CN' => 'Chinese',
                                    'ar' => 'Arabic',
                                    'hi' => 'Hindi',
                                ];
                            @endphp

                            <select wire:model="language" id="language"
                                class="bg-gray-300 text-gray-800 rounded-md p-2 font-medium">
                                <option value="">Select Language</option>
                                @foreach ($languages as $code => $name)
                                    <option class="bg-white text-gray-700  font-medium" value="{{ $code }}">
                                        {{ $name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <button data-modal-hide="create-modal" wire:click="createCampaign()" type="button"
                            class="btn cursor-pointer">Create campaign</button>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <script>
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
