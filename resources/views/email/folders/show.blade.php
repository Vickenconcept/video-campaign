<x-app-layout>
    <div class="container mx-auto py-8 px-3 pb-32 overflow-y-auto h-screen">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('email.folders.index') }}" 
                   class="text-gray-600 hover:text-gray-900">
                    ← Back to Folders
                </a>
                <div class="flex items-center space-x-3">
                    <div class="w-6 h-6 rounded-full" style="background-color: {{ $folder->color }}"></div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $folder->name }}</h1>
                </div>
            </div>
            <a href="{{ route('email.campaigns.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Create Campaign
            </a>
        </div>

        @if($folder->description)
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                <p class="text-gray-700">{{ $folder->description }}</p>
            </div>
        @endif

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ $campaigns->count() }} {{ Str::plural('Campaign', $campaigns->count()) }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('email.folders.edit', $folder) }}" 
                   class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md border border-gray-300 hover:bg-gray-50">
                    Edit Folder
                </a>
            </div>
        </div>

        @if($campaigns->isEmpty())
            <div class="text-center py-12">
                <div class="mb-4">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No campaigns in this folder</h3>
                <p class="text-gray-500 mb-6">Create your first campaign to get started.</p>
                <a href="{{ route('email.campaigns.create') }}" 
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Create Your First Campaign
                </a>
            </div>
        @else
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Campaign
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Recipients
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($campaigns as $campaign)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $campaign->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $campaign->subject }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($campaign->status === 'sent') bg-green-100 text-green-800
                                            @elseif($campaign->status === 'scheduled') bg-yellow-100 text-yellow-800
                                            @elseif($campaign->status === 'draft') bg-gray-100 text-gray-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($campaign->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $campaign->total_recipients }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $campaign->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('email.campaigns.show', $campaign) }}" 
                                               class="text-blue-600 hover:text-blue-900">View</a>
                                            <a href="{{ route('email.campaigns.edit', $campaign) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <a href="{{ route('email.campaigns.preview', $campaign) }}" 
                                               class="text-green-600 hover:text-green-900">Preview</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-app-layout> 