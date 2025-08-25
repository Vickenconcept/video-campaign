<x-app-layout>
    <div class="container mx-auto px-3 pb-32 pt-5 overflow-y-auto h-screen">
        <!-- Enhanced Header Section -->
        <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-6 shadow-2xl shadow-gray-500/20 border border-gray-200 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Email Campaign Folders</h1>
                    <p class="text-gray-600">Organize and manage your email campaigns with custom folders</p>
                </div>
                <a href="{{ route('email.folders.create') }}" 
                   class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                   <i class='bx bx-plus text-lg'></i>
                   <span>Create New Folder</span>
                </a>
            </div>
        </div>

        <!-- Enhanced Session Messages -->
        @if(session('success'))
            <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <i class='bx bx-check-circle text-xl text-green-600'></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if($folders->isEmpty())
            <!-- Enhanced Empty State -->
            <div class="text-center py-16">
                <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-8 shadow-sm border border-gray-200 max-w-md mx-auto">
                    <div class="mb-6">
                        <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                            <i class='bx bx-folder text-4xl text-gray-400'></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">No folders yet</h3>
                    <p class="text-gray-600 mb-6">Create your first folder to organize your email campaigns.</p>
                    <a href="{{ route('email.folders.create') }}" 
                       class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-8 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center gap-2">
                        <i class='bx bx-plus text-lg'></i>
                        <span>Create Your First Folder</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Enhanced Filters -->
            <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-6 shadow-sm border border-gray-200 mb-8">
                <form method="GET" action="{{ route('email.folders.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <div class="relative">
                            <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   placeholder="Search folders..." 
                                   class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" id="filter-btn" 
                                class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg font-medium shadow-md hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                            <i class='bx bx-search text-lg'></i> 
                            <span id="filter-text">Filter</span>
                        </button>
                        <a href="{{ route('email.folders.index') }}" 
                           class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-3 rounded-lg font-medium shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                            <i class='bx bx-x text-lg'></i>
                            <span>Clear</span>
                        </a>
                    </div>
                </form>
            </div>

            <!-- Enhanced Folder Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($folders as $folder)
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                        <div class="p-6">
                            <!-- Folder Header -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-5 h-5 rounded-full shadow-sm" style="background-color: {{ $folder->color }}"></div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $folder->name }}</h3>
                                </div>
                                <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <a href="{{ route('email.folders.edit', $folder) }}" 
                                       class="text-gray-500 hover:text-blue-600 hover:bg-blue-50 p-2 rounded-lg transition-all duration-200 flex items-center gap-1 font-semibold">
                                        <i class='bx bx-edit text-sm'></i>
                                    </a>
                                    <form action="{{ route('email.folders.destroy', $folder) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-gray-500 hover:text-red-600 hover:bg-red-50 p-2 rounded-lg transition-all duration-200 flex items-center gap-1 font-semibold" 
                                                onclick="return confirm('Are you sure you want to delete this folder? Campaigns will be moved to uncategorized.')">
                                            <i class='bx bx-trash text-sm'></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Folder Description -->
                            @if($folder->description)
                                <p class="text-gray-600 mb-4 text-sm leading-relaxed">{{ $folder->description }}</p>
                            @endif
                            
                            <!-- Folder Stats -->
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-6">
                                <span class="font-medium">{{ $folder->campaigns_count }} {{ Str::plural('campaign', $folder->campaigns_count) }}</span>
                                <span class="text-xs">Created {{ $folder->formatted_created_at }}</span>
                            </div>
                            
                            <!-- View Campaigns Button -->
                            <a href="{{ route('email.folders.show', $folder) }}" 
                               class="block w-full text-center bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 px-4 py-3 rounded-lg hover:from-gray-200 hover:to-gray-300 transition-all duration-200 font-medium shadow-sm hover:shadow-md">
                                View Campaigns
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Enhanced Pagination -->
            <div class="mt-8 bg-gradient-to-r from-gray-50 to-white rounded-xl p-6 shadow-sm border border-gray-200">
                {{ $folders->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.querySelector('form[method="GET"]');
            const filterBtn = document.getElementById('filter-btn');
            const filterIcon = document.getElementById('filter-icon');
            const filterText = document.getElementById('filter-text');
            
            if (filterForm && filterBtn && filterIcon && filterText) {
                filterForm.addEventListener('submit', function() {
                    // Disable button and show loading state
                    filterBtn.disabled = true;
                    filterIcon.className = 'bx bx-loader-alt animate-spin text-lg';
                    filterText.textContent = 'Filtering...';
                });
            }
        });
    </script>
</x-app-layout> 