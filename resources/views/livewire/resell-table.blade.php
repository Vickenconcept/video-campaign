<div>
    <div class="relative overflow-x-auto shadow-lg rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-900">
            <thead class="bg-gradient-to-r from-purple-50 to-purple-100 text-xs font-semibold text-purple-900 uppercase tracking-wider">
                <tr>
                    <th scope="col" class="px-6 py-4 border-b border-purple-200">
                        <div class="flex items-center gap-2">
                            <i class='bx bx-user text-purple-600'></i>
                            <span>Name</span>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-4 border-b border-purple-200">
                        <div class="flex items-center gap-2">
                            <i class='bx bx-envelope text-purple-600'></i>
                            <span>Email</span>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-4 border-b border-purple-200">
                        <div class="flex items-center gap-2">
                            <i class='bx bx-calendar text-purple-600'></i>
                            <span>Registration Date</span>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-4 border-b border-purple-200">
                        <div class="flex items-center gap-2">
                            <i class='bx bx-cog text-purple-600'></i>
                            <span>Actions</span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr class="hover:bg-purple-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">User ID: {{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i class='bx bx-envelope text-gray-400 mr-2'></i>
                                <span class="text-gray-900">{{ $user->email }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i class='bx bx-calendar text-gray-400 mr-2'></i>
                                <span class="text-gray-900">{{ $user->created_at->format('M j, Y') }}</span>
                                <div class="ml-2 text-xs text-gray-500">{{ $user->created_at->format('g:i A') }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <!-- Delete User Button -->
                                <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-all duration-200" title="Delete User">
                                    <i class='bx bx-trash text-lg'></i>
                                </button>

                                <!-- Enhanced Dropdown menu -->
                                <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-48 border border-gray-200">
                                    <div class="px-4 py-3 border-b border-gray-200">
                                        <h3 class="text-sm font-semibold text-gray-900">Confirm Deletion</h3>
                                        <p class="text-xs text-gray-500 mt-1">This action cannot be undone.</p>
                                    </div>
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                                        <li class="px-4 py-2 hover:bg-red-50 text-red-600 hover:text-red-700 cursor-pointer transition-colors duration-200 flex items-center justify-between" wire:click="deletUser({{ $user->id }})">
                                            <span>Delete User</span>
                                            <i class='bx bx-trash text-md'></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-8 max-w-md mx-auto border border-gray-200">
                                <div class="mb-4">
                                    <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                        <i class='bx bx-users text-4xl text-gray-400'></i>
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Users Found</h3>
                                <p class="text-gray-600 mb-4">Start building your reseller network by registering new users.</p>
                                <div class="text-sm text-gray-500">
                                    <i class='bx bx-info-circle mr-1'></i>
                                    Users will appear here once registered
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Enhanced Pagination -->
        @if($users->hasPages())
            <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
