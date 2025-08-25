<x-app-layout>
<div class="container mx-auto px-3 pb-32 pt-5 overflow-y-auto h-screen">
    <!-- Enhanced Header Section -->
    <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-6 shadow-2xl shadow-gray-500/20 border border-gray-200 mb-8">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Video Email Campaigns</h1>
                <p class="text-gray-600">Manage and track your email marketing campaigns</p>
            </div>
            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                <a href="{{ route('email.folders.index') }}" 
                   class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-medium py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                    <i class='bx bx-folder text-lg'></i>
                    <span>Manage Folders</span>
                </a>
                <a href="{{ route('email.campaigns.create') }}" 
                   class="bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-medium py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                    <i class='bx bx-plus text-lg'></i>
                    <span>Create New Campaign</span>
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
                <i class='bx bx-x-circle text-xl text-red-600'></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Enhanced Main Container -->
    <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
        <!-- Enhanced Header -->
        <div class="px-6 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-xl font-semibold text-gray-900">Your Campaigns</h2>
        </div>
        
        <!-- Enhanced Filters -->
        <div class="px-6 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <form method="GET" action="{{ route('email.campaigns.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="Search campaigns..." 
                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                    </div>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                    </select>
                </div>
                <div>
                    <label for="folder" class="block text-sm font-medium text-gray-700 mb-2">Folder</label>
                    <select name="folder" id="folder" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                        <option value="all" {{ request('folder') == 'all' || !request('folder') ? 'selected' : '' }}>All Folders</option>
                        @foreach($folders as $folder)
                            <option value="{{ $folder->id }}" {{ request('folder') == $folder->id ? 'selected' : '' }}>
                                {{ $folder->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit" id="filter-btn" class="flex-1 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-medium shadow-md hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <i class='bx bx-search text-lg' id="filter-icon"></i>
                        <span id="filter-text">Filter</span>
                    </button>
                    <a href="{{ route('email.campaigns.index') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-3 rounded-lg font-medium shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                        <i class='bx bx-x text-lg'></i>
                        <span>Clear</span>
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Enhanced Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Campaign
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Folder
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Recipients
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Scheduled
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($campaigns as $campaign)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900 mb-1">{{ $campaign->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $campaign->subject }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @if($campaign->folder)
                                    <div class="flex items-center space-x-3">
                                        <div class="w-4 h-4 rounded-full shadow-sm" style="background-color: {{ $campaign->folder->color }}"></div>
                                        <span class="text-sm font-medium text-gray-900">{{ $campaign->folder->name }}</span>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400 italic">No Folder</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm
                                    @if($campaign->status === 'sent') bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300
                                    @elseif($campaign->status === 'scheduled') bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-300
                                    @elseif($campaign->status === 'draft') bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border border-gray-300
                                    @else bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300 @endif">
                                    {{ ucfirst($campaign->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $campaign->total_recipients }}</div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @if($campaign->scheduled_at)
                                    <div class="text-sm font-medium text-gray-900">{{ $campaign->scheduled_at->format('M j, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $campaign->scheduled_at->format('g:i A') }}</div>
                                @else
                                    <span class="text-sm text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('email.campaigns.show', $campaign) }}" 
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                                        <i class='bx bx-show text-sm'></i>
                                        <span>View</span>
                                    </a>
                                    <a href="{{ route('email.campaigns.edit', $campaign) }}" 
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition-colors duration-200">
                                        <i class='bx bx-edit text-sm'></i>
                                        <span>Edit</span>
                                    </a>
                                    <a href="{{ route('email.campaigns.preview', $campaign) }}" 
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-colors duration-200">
                                        <i class='bx bx-play text-sm'></i>
                                        <span>Preview</span>
                                    </a>
                                    @if($campaign->status === 'draft')
                                        <form action="{{ route('email.campaigns.send-now', $campaign) }}" 
                                              method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-orange-600 hover:text-orange-800 hover:bg-orange-50 rounded-lg transition-colors duration-200"
                                                    onclick="return confirm('Send this campaign now?')">
                                                <i class='bx bx-send text-sm'></i>
                                                <span>Send</span>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('email.campaigns.destroy', $campaign) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200"
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
                                <div class="text-gray-500">
                                    <div class="mb-4">
                                        <i class='bx bx-envelope text-4xl text-gray-300'></i>
                                    </div>
                                    <p class="text-lg font-medium text-gray-900 mb-2">No campaigns found</p>
                                    <p class="text-gray-500 mb-4">Get started by creating your first email campaign</p>
                                    <a href="{{ route('email.campaigns.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-medium py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                        <i class='bx bx-plus text-lg'></i>
                                        <span>Create your first campaign</span>
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
        
        filterForm.addEventListener('submit', function() {
            // Disable button and show loading state
            filterBtn.disabled = true;
            filterIcon.className = 'bx bx-loader-alt animate-spin text-lg';
            filterText.textContent = 'Filtering...';
        });
    });
</script>
</x-app-layout>