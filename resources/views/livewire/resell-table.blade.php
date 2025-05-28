<div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-white0 ">
            <thead class="text-xs text-gray-700 uppercase ">
                <tr>
                    <th scope="col" class="px-6 py-3 bg-white ">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3 bg-white ">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50">

                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b border-gray-200 ">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-white  ">
                            {{ $user->name }}
                        </th>
                        <td class="px-6 py-4 bg-gray-50">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 bg-white ">
                            {{ $user->created_at }}
                        </td>
                        <td class="px-6 py-4 bg-gray-50">

                            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"> <i
                                    class='bx bxs-trash text-xl text-red-500 hover:text-red-700'></i>
                            </button>

                            <!-- Dropdown menu -->
                            <div id="dropdown"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                                <ul class="py-2 text-sm text-gray-700 "
                                    aria-labelledby="dropdownDefaultButton">
                                    <li class="hover:bg-red-200 text-red-500 hover:text-red-700 cursor-pointer"
                                        wire:click="deletUser({{ $user->id }})">
                                        Are you sure ?<i class='bx bxs-trash text-md ml-2 '></i>

                                    </li>

                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="bg-indigo-100 text-indigo-500 py-10 text-center rounded col-span-4" colspan="4">No Data
                            Yet.</td>
                    </tr>
                @endforelse

            </tbody>
            {{ $users->links() }}
        </table>
    </div>

</div>
