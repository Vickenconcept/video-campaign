<x-app-layout>
    <div class="container mx-auto px-3 pb-32 overflow-y-auto h-screen">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Email Preview</h1>
                <div class="flex space-x-4">
                    <a href="{{ route('email.campaigns.show', $campaign) }}" class="text-gray-600 hover:text-gray-900">← Back to Campaign</a>
                    <a href="{{ route('email.campaigns.templates', $campaign) }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                        Change Template
                    </a>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Campaign: {{ $campaign->title }}</h2>
                <p class="text-gray-600">Current Template: <span class="font-semibold capitalize">{{ $campaign->template }}</span></p>
            </div>

            <!-- Email Preview Container -->
            <div class="bg-white border rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gray-100 px-6 py-3 border-b">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Email Preview - {{ ucfirst($campaign->template) }} Template</span>
                        <span class="text-xs text-gray-500">Subject: {{ $campaign->subject }}</span>
                    </div>
                </div>
                
                <div class="p-0">
                    <iframe 
                        src="{{ route('email.campaigns.preview.iframe', $campaign) }}" 
                        class="w-full h-[800px] border-0"
                        title="Email Preview">
                    </iframe>
                </div>
            </div>

            <!-- Campaign Details -->
            <div class="mt-8 bg-white border rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Campaign Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-700"><span class="font-semibold">Subject:</span> {{ $campaign->subject }}</p>
                        <p class="text-gray-700"><span class="font-semibold">Status:</span> <span class="capitalize">{{ $campaign->status }}</span></p>
                        <p class="text-gray-700"><span class="font-semibold">Template:</span> <span class="capitalize">{{ $campaign->template }}</span></p>
                    </div>
                    <div>
                        <p class="text-gray-700"><span class="font-semibold">Recipients:</span> {{ $campaign->recipients->count() }}</p>
                        <p class="text-gray-700"><span class="font-semibold">Scheduled:</span> {{ $campaign->scheduled_at ? $campaign->scheduled_at->format('M j, Y g:i A') : 'Not scheduled' }}</p>
                        <p class="text-gray-700"><span class="font-semibold">CTA:</span> {{ $campaign->cta_text ?: 'None' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 