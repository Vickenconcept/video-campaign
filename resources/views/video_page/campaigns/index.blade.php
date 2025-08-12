<x-app-layout>
<div class="container mx-auto px-3 pb-32 overflow-y-auto h-screen">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Video Page </h1>
        <div class="flex space-x-3">
           
            <a href="{{ route('video-page.campaigns.create') }}" 
               class="bg-indigo-700 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">
                Create New Video Page
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Your Video Pages</h2>
        </div>
        
        <!-- Filters -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <form method="GET" action="{{ route('video-page.campaigns.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Search video page..." 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                    </select>
                </div>
               
                <div class="flex items-end gap-2">
                    <button type="submit" id="filter-btn" class="flex-1 bg-indigo-700 hover:bg-indigo-800 text-white px-4 py-2 rounded-md font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class='bx bx-search mr-2' id="filter-icon"></i>
                        <span id="filter-text">Filter</span>
                    </button>
                    <a href="{{ route('video-page.campaigns.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md font-semibold">
                        <i class='bx bx-x mr-2'></i>Clear
                    </a>
                </div>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Video Page
                        </th>
                       
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Recipients
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Scheduled
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($campaigns as $campaign)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $campaign->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $campaign->subject }}</div>
                                </div>
                            </td>
                           
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($campaign->status === 'sent') bg-green-100 text-green-800
                                    @elseif($campaign->status === 'scheduled') bg-yellow-100 text-yellow-800
                                    @elseif($campaign->status === 'draft') bg-gray-100 text-gray-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($campaign->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $campaign->total_recipients }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($campaign->scheduled_at)
                                    {{ $campaign->scheduled_at->format('M j, Y g:i A') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('video-page.campaigns.show', $campaign) }}" 
                                       class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                                        <i class='bx bx-show'></i>View
                                    </a>
                                    <a href="{{ route('video-page.campaigns.edit', $campaign) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 flex items-center gap-1">
                                        <i class='bx bx-edit'></i>Edit
                                    </a>
                                    <a href="{{ route('video-page.campaigns.preview', $campaign) }}" 
                                       class="text-green-600 hover:text-green-900 flex items-center gap-1">
                                        <i class='bx bx-play'></i>Preview
                                    </a>
                                    @if($campaign->status === 'draft')
                                        <form action="{{ route('video-page.campaigns.send-now', $campaign) }}" 
                                              method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="text-orange-600 hover:text-orange-900 flex items-center gap-1"
                                                    onclick="return confirm('Send this campaign now?')">
                                                <i class='bx bx-send'></i>Send
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('video-page.campaigns.destroy', $campaign) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 flex items-center gap-1"
                                                onclick="return confirm('Delete this campaign?')">
                                            <i class='bx bx-trash'></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No campaigns found. <a href="{{ route('video-page.campaigns.create') }}" class="text-blue-600 hover:text-blue-900">Create your first video page</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $campaigns->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.querySelector('form[method="GET"]');
        const filterBtn = document.getElementById('filter-btn');
        const filterIcon = document.getElementById('filter-icon');
        const filterText = document.getElementById('filter-text');
        
        filterForm.addEventListener('submit', function() {
            // Disable button and show loading state
            filterBtn.disabled = true;
            filterIcon.className = 'bx bx-loader-alt animate-spin mr-2';
            filterText.textContent = 'Filtering...';
        });
    });
</script>
</x-app-layout>