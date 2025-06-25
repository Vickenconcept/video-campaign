<x-app-layout>
    <div class="container mx-auto px-3 pb-32 overflow-y-auto h-screen">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Email Templates</h1>
                <a href="{{ route('email.campaigns.show', $campaign) }}" class="text-gray-600 hover:text-gray-900">← Back to Campaign</a>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Select a Template for: {{ $campaign->title }}</h2>
                <p class="text-gray-600">Choose how your email content will be displayed to recipients</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Template 1: Classic -->
                <div class="bg-white border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        <div class="text-center text-white">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <h3 class="text-lg font-semibold">Classic</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Classic Template</h3>
                        <p class="text-sm text-gray-600 mb-3">Clean, professional layout with centered content and prominent video thumbnail.</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('email.campaigns.template.preview', ['campaign' => $campaign, 'template' => 'classic']) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">Preview</a>
                            <form action="{{ route('email.campaigns.template.apply', $campaign) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="template" value="classic">
                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Template 2: Modern -->
                <div class="bg-white border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center">
                        <div class="text-center text-white">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <h3 class="text-lg font-semibold">Modern</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Modern Template</h3>
                        <p class="text-sm text-gray-600 mb-3">Contemporary design with side-by-side content and video thumbnail.</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('email.campaigns.template.preview', ['campaign' => $campaign, 'template' => 'modern']) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">Preview</a>
                            <form action="{{ route('email.campaigns.template.apply', $campaign) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="template" value="modern">
                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Template 3: Minimalist -->
                <div class="bg-white border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center">
                        <div class="text-center text-white">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                            </svg>
                            <h3 class="text-lg font-semibold">Minimalist</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Minimalist Template</h3>
                        <p class="text-sm text-gray-600 mb-3">Simple, clean design focusing on content with subtle styling.</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('email.campaigns.template.preview', ['campaign' => $campaign, 'template' => 'minimalist']) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">Preview</a>
                            <form action="{{ route('email.campaigns.template.apply', $campaign) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="template" value="minimalist">
                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Template 4: Bold -->
                <div class="bg-white border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center">
                        <div class="text-center text-white">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            <h3 class="text-lg font-semibold">Bold</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Bold Template</h3>
                        <p class="text-sm text-gray-600 mb-3">High-impact design with large video thumbnail and prominent CTA.</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('email.campaigns.template.preview', ['campaign' => $campaign, 'template' => 'bold']) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">Preview</a>
                            <form action="{{ route('email.campaigns.template.apply', $campaign) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="template" value="bold">
                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Template 5: Newsletter -->
                <div class="bg-white border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                        <div class="text-center text-white">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                            </svg>
                            <h3 class="text-lg font-semibold">Newsletter</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Newsletter Template</h3>
                        <p class="text-sm text-gray-600 mb-3">Professional newsletter layout with header, content sections, and footer.</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('email.campaigns.template.preview', ['campaign' => $campaign, 'template' => 'newsletter']) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">Preview</a>
                            <form action="{{ route('email.campaigns.template.apply', $campaign) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="template" value="newsletter">
                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Template 6: Custom -->
                <div class="bg-white border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-indigo-500 to-cyan-500 flex items-center justify-center">
                        <div class="text-center text-white">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                            </svg>
                            <h3 class="text-lg font-semibold">Custom</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Custom Template</h3>
                        <p class="text-sm text-gray-600 mb-3">Create your own custom layout with advanced styling options.</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('email.campaigns.template.preview', ['campaign' => $campaign, 'template' => 'custom']) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">Preview</a>
                            <form action="{{ route('email.campaigns.template.apply', $campaign) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="template" value="custom">
                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 