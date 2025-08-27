<x-app-layout>
    <div class=" bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8 h-screen overflow-y-auto pb-40">
        <div class="container mx-auto px-4 max-w-6xl">
            <!-- Enhanced Header Section -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl shadow-slate-500/10 border border-white/20 p-8 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 to-indigo-800 bg-clip-text text-transparent mb-3">
                            Video Page: {{ $campaign->title }}
                        </h1>
                        <p class="text-lg text-slate-600">
                            Campaign details and recipient analytics
                        </p>
                    </div>
                    
                    <!-- Enhanced Action Buttons -->
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('video-page.campaigns.edit', $campaign) }}" 
                            class="inline-flex items-center gap-3 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-semibold">
                            <i class='bx bx-edit text-xl'></i>
                            Edit Campaign
                        </a>
                        
                        <a href="{{ route('video-page.campaigns.preview', $campaign) }}" 
                            class="inline-flex items-center gap-3 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-semibold">
                            <i class='bx bx-show text-xl'></i>
                            Preview
                        </a>
                        
                        @if($campaign->status !== 'sent')
                            <form action="{{ route('video-page.campaigns.send-now', $campaign) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                    class="inline-flex items-center gap-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-semibold">
                                    <i class='bx bx-send text-xl'></i>
                                    Send Now
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Enhanced Campaign Stats -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl shadow-slate-500/10 border border-white/20 p-8 mb-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                    <i class='bx bx-stats text-indigo-600'></i>
                    Campaign Statistics
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Campaign Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                            <i class='bx bx-info-circle text-blue-600'></i>
                            Campaign Information
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                                <i class='bx bx-envelope text-slate-500'></i>
                                <span class="text-slate-700"><span class="font-semibold">Subject:</span> {{ $campaign->subject }}</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                                <i class='bx bx-circle text-slate-500'></i>
                                <span class="text-slate-700"><span class="font-semibold">Status:</span> 
                                    <span class="capitalize px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-medium">{{ $campaign->status }}</span>
                                </span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                                <i class='bx bx-calendar text-slate-500'></i>
                                <span class="text-slate-700"><span class="font-semibold">Scheduled:</span> {{ $campaign->scheduled_at ? \Illuminate\Support\Carbon::parse($campaign->scheduled_at)->format('M j, Y g:i A') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Performance Metrics -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                            <i class='bx bx-trending-up text-emerald-600'></i>
                            Performance Metrics
                        </h3>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200">
                                <div class="text-2xl font-bold text-blue-700">{{ $stats['total_recipients'] }}</div>
                                <div class="text-sm text-blue-600">Total Recipients</div>
                            </div>
                            <div class="bg-gradient-to-r from-emerald-50 to-green-50 p-4 rounded-xl border border-emerald-200">
                                <div class="text-2xl font-bold text-emerald-700">{{ $stats['total_recipients'] ? round($stats['viewed'] / max(1, $stats['total_recipients']) * 100, 1) : 0 }}%</div>
                                <div class="text-sm text-emerald-600">View Rate</div>
                            </div>
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-4 rounded-xl border border-purple-200">
                                <div class="text-2xl font-bold text-purple-700">{{ $stats['total_recipients'] ? round($stats['clicked'] / max(1, $stats['total_recipients']) * 100, 1) : 0 }}%</div>
                                <div class="text-sm text-purple-600">Click Rate</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Enhanced Message Preview -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl shadow-slate-500/10 border border-white/20 p-8 mb-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                    <i class='bx bx-message-square-dots text-indigo-600'></i>
                    Message Preview
                </h2>
                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                    <div class="prose prose-slate max-w-none">
                        {!! nl2br(e($campaign->body)) !!}
                    </div>
                </div>
            </div>
            
            <!-- Enhanced Recipients Table -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl shadow-slate-500/10 border border-white/20 p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                        <i class='bx bx-users text-indigo-600'></i>
                        Recipients
                    </h2>
                    <div class="flex items-center gap-3">
                        <span class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                            <i class='bx bx-message-circle mr-2'></i>
                            Total Chats: {{ $totalReplies }}
                        </span>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b-2 border-slate-200">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider bg-slate-50 rounded-l-xl">
                                    <i class='bx bx-envelope mr-2'></i>Email
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider bg-slate-50">
                                    <i class='bx bx-show mr-2'></i>Viewed
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider bg-slate-50">
                                    <i class='bx bx-mouse mr-2'></i>Clicked
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider bg-slate-50">
                                    <i class='bx bx-message-circle mr-2'></i>Chats
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider bg-slate-50 rounded-r-xl">
                                    <i class='bx bx-cog mr-2'></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @foreach($recipients as $recipient)
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <td class="px-6 py-4 text-slate-900 font-medium">{{ $recipient->email }}</td>
                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $recipient->viewed_at ? \Illuminate\Support\Carbon::parse($recipient->viewed_at)->format('M j, Y g:i A') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $recipient->clicked_at ? \Illuminate\Support\Carbon::parse($recipient->clicked_at)->format('M j, Y g:i A') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800">
                                            {{ $recipientReplyCounts[$recipient->uuid] ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('email.tracking.view', ['r' => $recipient->uuid]) }}" target="_blank" 
                                            class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 text-sm font-semibold">
                                            <i class='bx bx-show'></i>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Enhanced Pagination -->
                    <div class="mt-6 flex justify-center">
                        <div class="bg-white rounded-xl shadow-md border border-slate-200">
                            {{ $recipients->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 