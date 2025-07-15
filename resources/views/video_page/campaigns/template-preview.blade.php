<x-app-layout>
    <div class="container mx-auto px-3 pb-32 overflow-y-auto h-screen">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Template Preview</h1>
                <div class="flex space-x-4">
                    <a href="{{ route('email.campaigns.templates', $campaign) }}" class="text-gray-600 hover:text-gray-900">← Back to Templates</a>
                    <form action="{{ route('email.campaigns.template.apply', $campaign) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="template" value="{{ $template }}">
                        <button type="submit" class="bg-indigo-700 text-white px-4 py-2 rounded-lg hover:bg-indigo-800">Apply Template</button>
                    </form>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ ucfirst($template) }} Template Preview</h2>
                <p class="text-gray-600">This is how your email will appear to recipients with the {{ ucfirst($template) }} template</p>
            </div>

            <!-- Email Preview Container -->
            <div class="bg-white border rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gray-100 px-6 py-3 border-b">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Email Preview - {{ ucfirst($template) }} Template</span>
                        <span class="text-xs text-gray-500">Subject: {{ $campaign->subject }}</span>
                    </div>
                </div>
                
                <div class="p-0">
                    <iframe 
                        src="{{ route('email.campaigns.template.preview.iframe', ['campaign' => $campaign, 'template' => $template]) }}" 
                        class="w-full h-[800px] border-0"
                        title="Template Preview">
                    </iframe>
                </div>
            </div>

            <!-- Template Features -->
            <div class="mt-8 bg-white border rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ ucfirst($template) }} Template Features</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($template === 'classic')
                        <div>
                            <p class="text-gray-700"><span class="font-semibold">Layout:</span> Centered content with prominent video</p>
                            <p class="text-gray-700"><span class="font-semibold">Style:</span> Clean and professional</p>
                            <p class="text-gray-700"><span class="font-semibold">Best for:</span> Business communications</p>
                        </div>
                    @elseif($template === 'modern')
                        <div>
                            <p class="text-gray-700"><span class="font-semibold">Layout:</span> Side-by-side content and video</p>
                            <p class="text-gray-700"><span class="font-semibold">Style:</span> Contemporary with gradients</p>
                            <p class="text-gray-700"><span class="font-semibold">Best for:</span> Modern brands</p>
                        </div>
                    @elseif($template === 'minimalist')
                        <div>
                            <p class="text-gray-700"><span class="font-semibold">Layout:</span> Simple, clean design</p>
                            <p class="text-gray-700"><span class="font-semibold">Style:</span> Minimal and elegant</p>
                            <p class="text-gray-700"><span class="font-semibold">Best for:</span> Focused messaging</p>
                        </div>
                    @elseif($template === 'bold')
                        <div>
                            <p class="text-gray-700"><span class="font-semibold">Layout:</span> High-impact with large elements</p>
                            <p class="text-gray-700"><span class="font-semibold">Style:</span> Bold and attention-grabbing</p>
                            <p class="text-gray-700"><span class="font-semibold">Best for:</span> Promotional campaigns</p>
                        </div>
                    @elseif($template === 'newsletter')
                        <div>
                            <p class="text-gray-700"><span class="font-semibold">Layout:</span> Professional header and footer</p>
                            <p class="text-gray-700"><span class="font-semibold">Style:</span> Newsletter format</p>
                            <p class="text-gray-700"><span class="font-semibold">Best for:</span> Regular updates</p>
                        </div>
                    @elseif($template === 'custom')
                        <div>
                            <p class="text-gray-700"><span class="font-semibold">Layout:</span> Modern gradient design</p>
                            <p class="text-gray-700"><span class="font-semibold">Style:</span> Advanced styling</p>
                            <p class="text-gray-700"><span class="font-semibold">Best for:</span> Creative campaigns</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-gray-700"><span class="font-semibold">Video Support:</span> ✅ Included</p>
                        <p class="text-gray-700"><span class="font-semibold">CTA Button:</span> ✅ Styled</p>
                        <p class="text-gray-700"><span class="font-semibold">Tracking:</span> ✅ Enabled</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 