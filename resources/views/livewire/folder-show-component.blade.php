<div class=" h-screen overflow-y-auto px-5">
    <div wire:key="message-{{ now() }}">
        <x-session-msg />
    </div>

    @if (count($campaigns ?? []) > 0)
        <div class="h-full  space-y-10">
            <div class="flex justify-between">
                <div>

                </div>
                <div class="max-w-xs w-full">
                    <button class="btn cursor-pointer" data-modal-target="create-modal"
                        data-modal-toggle="create-modal">Create
                        Campaign</button>
                </div>
            </div>

            <section class="grid lg:grid-cols-4 gap-5">
                <div class="lg:col-span-1">
                    <div class="max-w-sm mx-auto">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <ul class="divide-y divide-gray-200">
                                @forelse ($campaigns as $campaign)
                                    <li
                                        class="p-3 flex justify-between items-center user-card hover:shadow-2xl transition duration-500 ease-in-out">
                                        <div class="flex items-center w-[60%]">
                                            <img class="w-10 h-10 rounded-full"
                                                src="https://unsplash.com/photos/oh0DITWoHi4/download?force=true&w=640"
                                                alt="Christy">
                                            <span class="ml-3 font-medium  capitalize truncate " title="{{ $campaign->title }}">{{ $campaign->title }}  </span>
                                        </div>
                                        <div class="flex space-x-1">
                                            <a href="{{ route('campaign.show', ['uuid' => $campaign->uuid]) }}" class="text-gray-500 hover:text-gray-700 cursor-pointer ">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                            <button class="text-gray-500 hover:text-gray-700 cursor-pointer ">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                                </svg>
                                            </button>
                                        </div>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="lg:col-span-3 p-20 bg-slate-500 rounded-lg"></div>
            </section>
        </div>
    @endif

    @if (count($campaigns ?? []) == 0)
        <div class="h-[80%] flex justify-center items-center">
            <div class="max-w-sm w-full">
                <button class="btn cursor-pointer" data-modal-target="create-modal"
                    data-modal-toggle="create-modal">Create
                    Campaign</button>
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
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                                <input type="checkbox" value="1" class="sr-only peer" wire:model="contact_detail">
                                <div
                                    class="w-11 z-0 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-400  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-green-400">
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
                                    'zh' => 'Chinese',
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
                            class="btn cursor-pointer">Create
                            Folder</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
