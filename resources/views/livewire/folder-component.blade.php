<div class="py-5  px-3  md:px-3 overflow-y-auto h-full">
    @section('title')
        {{ 'Folders' }}
    @endsection
    <div
        class="border-b border-gray-200 py-6 flex flex-col md:flex-row justify-between items-center mb-8 space-y-4 md:space-y-0 bg-gradient-to-r from-gray-50 to-white rounded-xl p-6 shadow-2xl shadow-gray-500/20">
        <div class="w-full md:w-auto">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sort by</label>
            <select wire:model.live="sortOrder" class="form-control bg-white border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm transition-all duration-200">
                <option value="latest">Latest</option>
                <option value="oldest">Oldest</option>
            </select>
        </div>

        <div class="flex flex-col md:items-center md:flex-row md:px-3 md:space-y-0 md:space-x-4 w-full">

            <div class="relative w-full">
                <label class="block text-sm font-medium text-gray-700 mb-2">Search folders</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="search" wire:model.live="search"
                        class="block w-full p-3.5 ps-10 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all duration-200"
                        placeholder="Search folders...">
                </div>
            </div>

            <div wire:ignore class="w-full md:w-auto">
                <label class="block text-sm font-medium text-gray-700 mb-2 md:hidden">Create new</label>
                <button data-modal-target="create-modal" data-modal-toggle="create-modal"
                    class="w-full md:w-auto bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-medium py-3.5 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2" type="button">
                    <i class="bx bx-plus text-lg"></i>
                    <span class="hidden md:block text-nowrap">Create folder</span>
                </button>
            </div>
        </div>
    </div>

    <div wire:key="message-{{ now() }}">
        <x-session-msg />
    </div>


    <section>
        <ul class="w-full  divide-gray-200  grid sm:grid-cols-4 gap-5" x-data="{ folder: null, editFolder: false, openDelete: false }">
            @forelse ($folders as $folder)
                <div class="p-4 bg-white  rounded-xl shadow-2xl shadow-indigo-200/70  space-y-14 border-2 hover:!border-indigo-600 ">
                    <div class="flex justify-between">
                        <span class="  rounded-full">

                        </span>

                        <div class=" space-x-4 items-center flex ">
                            <button type="button" @click="editFolder = true "
                                wire:click="setFolder({{ $folder->id }}, '{{ addslashes($folder->name) }}')"
                                class="bg-gradient-to-r from-emerald-400 to-emerald-500 hover:from-emerald-500 hover:to-emerald-600 group cursor-pointer px-3 py-2 rounded-md text-sm flex items-center delay-100 transition-all duration-500 ease-in-out shadow-md hover:shadow-lg">
                                <i
                                    class="bx bx-edit font-medium text-white mr-1 text-lg delay-100 transition-all duration-500 ease-in-out"></i>

                            </button>
                            @if ($folder->status != 1)
                                <button type="button" @click="openDelete =true"
                                    wire:click="setFolder({{ $folder->id }}, '{{ addslashes($folder->name) }}')"
                                    class="delete-btn bg-gradient-to-r from-rose-400 to-rose-500 hover:from-rose-500 hover:to-rose-600 group cursor-pointer px-3 py-2 rounded-md text-sm flex items-center delay-100 transition-all duration-500 ease-in-out shadow-md hover:shadow-lg">
                                    <i
                                        class="bx bx-trash font-medium text-white mr-1 text-lg delay-100 transition-all duration-500 ease-in-out"></i>
                            @endif

                            </button>
                            <a href="{{ route('folder.show', ['uuid' => $folder->uuid]) }}"
                                class="bg-gradient-to-r from-slate-400 to-slate-500 hover:from-slate-500 hover:to-slate-600 group px-3 py-2 rounded-md text-sm flex items-center delay-100 transition-all duration-500 ease-in-out shadow-md hover:shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                </svg>
                            </a>

                        </div>
                    </div>
                    <div class="flex justify-between mt-10">
                        <div>
                            <p class="font-medium text-md capitalize">
                                {{ $folder->name }}
                            </p>
                            <p class="text-sm text-gray-500 capitalize">
                                {{ $folder->description }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-3 bg-gray-50 text-gray-500 py-8 flex flex-col justify-center items-center rounded ">
                    <span>No Data Yet.</span>
                    <p><i class='bx bxs-folder-open text-4xl'></i></p>
                </div>
            @endforelse

            <div class="md:col-span-3">
                {{ $folders->links() }}
            </div>

            <!-- edit campaign -->
            <div class="fixed items-center justify-center  flex top-0 left-0 mx-auto w-full h-full bg-slate-500/40 z-50 transition duration-1000 ease-in-out"
                x-show="editFolder" style="display: none;">
                <div @click.away="editFolder = false"
                    class="bg-white w-[90%] md:w-[50%]  shadow-inner  border rounded-2xl overflow-auto  py-6 px-8 transition-all relative duration-700">
                    <div class=" h-full ">

                        <div class="font-bold text-xl">Edit Folder Name</div>

                        <form action="" method="post" class="my-10 space-y-3">
                            @csrf

                            <div>
                                <input class="form-control" type="text" wire:model="name" placeholder="Folder Name">
                            </div>


                            <button class="btn cursor-pointer" type="button" wire:click="updateFolder()">
                                <span>Edit folder</span>
                            </button>
                    </div>
                </div>
            </div>


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
                                    <button type="button" @click="openDelete = false" wire:click="deleteForm()"
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
        </ul>


        <!-- Main modal -->
        <div id="create-modal" tabindex="-1" aria-hidden="true" wire:ignore
            class="hidden overflow-y-auto bg-slate-500/40 overflow-x-hidden fixed top-10 h-screen right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow border">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                        <h3 class="text-xl font-semibold text-gray-900 ">
                            Create Folder
                        </h3>

                        <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
                            data-modal-hide="create-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
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
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Name
                                    *</label>
                                <input type="text" wire:model="name" id="name" class="form-control "
                                    placeholder="Enter Folder name" />
                            </div>
                            <div>
                                <label for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                                <textarea wire:model="description" id="description" class="form-control"></textarea>
                            </div>

                            <button data-modal-hide="create-modal" wire:key="create" wire:click="createFolder()"
                                type="button" class="btn cursor-pointer">Create
                                Folder</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
</div>
