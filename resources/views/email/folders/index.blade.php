<x-app-layout>
    <div class="container mx-auto px-3 pb-32 overflow-y-auto h-screen">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Email Campaign Folders</h1>
            <a href="{{ route('email.folders.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Create New Folder
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($folders->isEmpty())
            <div class="text-center py-12">
                <div class="mb-4">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No folders yet</h3>
                <p class="text-gray-500 mb-6">Create your first folder to organize your email campaigns.</p>
                <a href="{{ route('email.folders.create') }}" 
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Create Your First Folder
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($folders as $folder)
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-4 h-4 rounded-full" style="background-color: {{ $folder->color }}"></div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $folder->name }}</h3>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('email.folders.edit', $folder) }}" 
                                       class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('email.folders.destroy', $folder) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-gray-400 hover:text-red-600"
                                                onclick="return confirm('Are you sure you want to delete this folder? Campaigns will be moved to uncategorized.')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            @if($folder->description)
                                <p class="text-gray-600 mb-4">{{ $folder->description }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span>{{ $folder->campaigns_count }} {{ Str::plural('campaign', $folder->campaigns_count) }}</span>
                                <span>Created {{ $folder->formatted_created_at }}</span>
                            </div>
                            
                            <a href="{{ route('email.folders.show', $folder) }}" 
                               class="block w-full text-center bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors">
                                View Campaigns
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout> 