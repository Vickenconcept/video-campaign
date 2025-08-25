<x-app-layout>
    <div class="container mx-auto px-3 pb-32 overflow-y-auto h-screen pt-5">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Email Preview</h1>
                <div class="flex space-x-4">
                    <a href="{{ route('video-page.campaigns.show', $campaign) }}" class="text-gray-600 hover:text-gray-900">← Back to Campaign</a>
                   
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
                        src="{{ route('video-page.campaigns.preview.iframe', $campaign) }}" 
                        class="w-full h-[800px] border-0"
                        title="Email Preview">
                    </iframe>
                </div>
            </div>

           
        </div>
    </div>
</x-app-layout> 