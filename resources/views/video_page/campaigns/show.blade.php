<x-app-layout>
    <div class="container mx-auto px-3 pb-32 overflow-y-auto h-screen">
        <div class="max-w-4xl mx-auto">
            <div class="  ">
                <h1 class="text-2xl font-bold mb-6">Video Page: {{ $campaign->title }}</h1>
                <div class="flex flex-wrap gap-3 mb-6">
                   
                   
                    <a href="{{ route('video-page.campaigns.edit', $campaign) }}" class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition-colors font-semibold">
                        <i class='bx bx-edit text-lg'></i> Edit
                    </a>
                    <a href="{{ route('video-page.campaigns.preview', $campaign) }}" class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition-colors font-semibold">
                        <i class='bx bx-show text-lg'></i> Preview
                    </a>
                    @if($campaign->status !== 'sent')
                        <form action="{{ route('video-page.campaigns.send-now', $campaign) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition-colors font-semibold">
                                <i class='bx bx-send text-lg'></i> Send Now
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            
            <div class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <div class="text-gray-700"><span class="font-semibold">Subject:</span> {{ $campaign->subject }}</div>
                        <div class="text-gray-700"><span class="font-semibold">Status:</span> <span class="capitalize">{{ $campaign->status }}</span></div>
                        <div class="text-gray-700"><span class="font-semibold">Scheduled:</span> {{ $campaign->scheduled_at ? \Illuminate\Support\Carbon::parse($campaign->scheduled_at)->format('M j, Y g:i A') : '-' }}</div>
                    </div>
                    <div>
                        <div class="text-gray-700"><span class="font-semibold">Total Recipients:</span> {{ $stats['total_recipients'] }}</div>
                        <div class="text-gray-700"><span class="font-semibold">View Rate:</span> {{ $stats['total_recipients'] ? round($stats['viewed'] / max(1, $stats['total_recipients']) * 100, 1) : 0 }}%</div>
                        <div class="text-gray-700"><span class="font-semibold">Click Rate:</span> {{ $stats['total_recipients'] ? round($stats['clicked'] / max(1, $stats['total_recipients']) * 100, 1) : 0 }}%</div>
                    </div>
                </div>
            </div>
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Message Preview</h2>
                <div class="bg-white border rounded p-4 mb-2">
                    {!! nl2br(e($campaign->body)) !!}
                </div>
               
            </div>
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Recipients</h2>
                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-semibold">Total Chats: {{ $totalReplies }}</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Viewed</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Clicked</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Chats</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recipients as $recipient)
                                <tr>
                                    <td class="px-4 py-2">{{ $recipient->email }}</td>
                                    <td class="px-4 py-2">{{ $recipient->viewed_at ? \Illuminate\Support\Carbon::parse($recipient->viewed_at)->format('M j, Y g:i A') : '-' }}</td>
                                    <td class="px-4 py-2">{{ $recipient->clicked_at ? \Illuminate\Support\Carbon::parse($recipient->clicked_at)->format('M j, Y g:i A') : '-' }}</td>
                                    <td class="px-4 py-2 text-center font-semibold">{{ $recipientReplyCounts[$recipient->uuid] ?? 0 }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('email.tracking.view', ['r' => $recipient->uuid]) }}" target="_blank" class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded text-xs font-semibold">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $recipients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 