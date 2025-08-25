<x-app-layout>
<div class="container mx-auto px-3 pb-32 pt-5 overflow-y-auto h-screen">
    <!-- Enhanced Header Section -->
    <div class="bg-white rounded-xl p-6 shadow-2xl shadow-gray-500/20 border border-gray-200 mb-8">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Video Page Campaigns</h1>
                <p class="text-gray-600">Create and manage your video page campaigns</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('video-page.campaigns.create') }}" 
                   class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                    <i class='bx bx-plus text-lg'></i>
                    <span>Create New Video Page</span>
                </a>
            </div>
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

    @if(session('error'))
        <div class="bg-gradient-to-r from-red-50 to-red-100 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6 shadow-sm">
            <div class="flex items-center gap-3">
                <i class='bx bx-error-circle text-xl text-red-600'></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Enhanced Main Container -->
    <div class="bg-white shadow-xl rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 px-6 py-4 border-b border-indigo-200">
            <h2 class="text-xl font-semibold text-indigo-900">Your Video Pages</h2>
            <p class="text-indigo-700 text-sm">Manage and organize your video page campaigns</p>
        </div>
        
        <!-- Enhanced Filters -->
        <div class="px-6 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <form method="GET" action="{{ route('video-page.campaigns.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="Search video page..." 
                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                    </div>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                    </select>
                </div>
               
                <div class="flex items-end gap-3">
                    <button type="submit" id="filter-btn" class="flex-1 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white px-6 py-3 rounded-lg font-medium shadow-md hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <i class='bx bx-search text-lg mr-2' id="filter-icon"></i>
                        <span id="filter-text">Filter</span>
                    </button>
                    <a href="{{ route('video-page.campaigns.index') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-3 rounded-lg font-medium shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                        <i class='bx bx-x text-lg mr-2'></i>
                        <span>Clear</span>
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Enhanced Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Video Page
                        </th>
                       
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Recipients
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Scheduled
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($campaigns as $campaign)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $campaign->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $campaign->subject }}</div>
                                </div>
                            </td>
                           
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm
                                    @if($campaign->status === 'sent') bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300
                                    @elseif($campaign->status === 'scheduled') bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-300
                                    @elseif($campaign->status === 'draft') bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border border-gray-300
                                    @else bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300 @endif">
                                    {{ ucfirst($campaign->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ $campaign->total_recipients }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($campaign->scheduled_at)
                                    {{ $campaign->scheduled_at->format('M j, Y g:i A') }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('video-page.campaigns.show', $campaign) }}" 
                                       class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 px-2 py-1 rounded-md transition-all duration-200 flex items-center gap-1">
                                        <i class='bx bx-show text-sm'></i>
                                        <span>View</span>
                                    </a>
                                    <a href="{{ route('video-page.campaigns.edit', $campaign) }}" 
                                       class="text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 px-2 py-1 rounded-md transition-all duration-200 flex items-center gap-1">
                                        <i class='bx bx-edit text-sm'></i>
                                        <span>Edit</span>
                                    </a>
                                    <a href="{{ route('video-page.campaigns.preview', $campaign) }}" 
                                       class="text-green-600 hover:text-green-800 hover:bg-green-50 px-2 py-1 rounded-md transition-all duration-200 flex items-center gap-1">
                                        <i class='bx bx-play text-sm'></i>
                                        <span>Preview</span>
                                    </a>
                                    @if($campaign->status === 'draft')
                                        <form action="{{ route('video-page.campaigns.send-now', $campaign) }}" 
                                              method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="text-orange-600 hover:text-orange-800 hover:bg-orange-50 px-2 py-1 rounded-md transition-all duration-200 flex items-center gap-1"
                                                    onclick="return confirm('Send this campaign now?')">
                                                <i class='bx bx-send text-sm'></i>
                                                <span>Send</span>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('video-page.campaigns.destroy', $campaign) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800 hover:bg-red-50 px-2 py-1 rounded-md transition-all duration-200 flex items-center gap-1"
                                                onclick="return confirm('Delete this campaign?')">
                                            <i class='bx bx-trash text-sm'></i>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-8 max-w-md mx-auto">
                                    <div class="mb-4">
                                        <i class='bx bx-video text-4xl text-gray-400 mx-auto'></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No campaigns found</h3>
                                    <p class="text-gray-500 mb-4">Create your first video page campaign to get started</p>
                                    <a href="{{ route('video-page.campaigns.create') }}" class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white px-6 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center gap-2">
                                        <i class='bx bx-plus text-sm'></i>
                                        <span>Create Your First Video Page</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Enhanced Pagination -->
            <div class="px-6 py-6 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-white">
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
        
        if (filterForm && filterBtn && filterIcon && filterText) {
            filterForm.addEventListener('submit', function() {
                // Disable button and show loading state
                filterBtn.disabled = true;
                filterIcon.className = 'bx bx-loader-alt animate-spin text-lg mr-2';
                filterText.textContent = 'Filtering...';
            });
        }
    });
</script>
</x-app-layout>