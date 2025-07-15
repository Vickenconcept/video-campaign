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

                <!-- Template 6: Gradient -->
                <div class="bg-white border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-pink-500 via-orange-400 to-yellow-400 flex items-center justify-center">
                        <div class="text-center text-white">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <defs>
                                    <linearGradient id="gradientIcon" x1="0" y1="0" x2="1" y2="1">
                                        <stop offset="0%" stop-color="#ee0979"/>
                                        <stop offset="100%" stop-color="#ff6a00"/>
                                    </linearGradient>
                                </defs>
                                <circle cx="12" cy="12" r="10" stroke="url(#gradientIcon)" fill="url(#gradientIcon)"/>
                                <path d="M8 12l2 2 4-4" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            </svg>
                            <h3 class="text-lg font-semibold">Gradient</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Gradient Template</h3>
                        <p class="text-sm text-gray-600 mb-3">Vibrant, modern look with a pink-orange gradient background and bold CTA. Perfect for eye-catching campaigns.</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('email.campaigns.template.preview', ['campaign' => $campaign, 'template' => 'gradient']) }}"
                               class="text-blue-600 hover:text-blue-800 text-sm">Preview</a>
                            <form action="{{ route('email.campaigns.template.apply', $campaign) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="template" value="gradient">
                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Template 7: Aqua -->
                <div class="bg-white border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-cyan-400 via-blue-400 to-teal-400 flex items-center justify-center">
                        <div class="text-center text-white">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="none" viewBox="0 0 24 24"><path d="M12 2C7 12 2 17 12 22C22 17 17 12 12 2Z" fill="#06b6d4" stroke="#38bdf8" stroke-width="2"/><circle cx="12" cy="17" r="2" fill="#38bdf8"/></svg>
                            <h3 class="text-lg font-semibold">Aqua</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Aqua Template</h3>
                        <p class="text-sm text-gray-600 mb-3">Fresh, clean look with blue/teal gradients and a bold aqua CTA. Great for tech or wellness brands.</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('email.campaigns.template.preview', ['campaign' => $campaign, 'template' => 'aqua']) }}"
                               class="text-blue-600 hover:text-blue-800 text-sm">Preview</a>
                            <form action="{{ route('email.campaigns.template.apply', $campaign) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="template" value="aqua">
                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Template 8: Dark -->
                <div class="bg-white border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-gray-900 via-gray-800 to-blue-900 flex items-center justify-center">
                        <div class="text-center text-white">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#18181b" stroke="#0ea5e9" stroke-width="2"/><path d="M16 12A4 4 0 1 1 8 12c0-2.21 1.79-4 4-4v4z" fill="#22d3ee"/><circle cx="17" cy="7" r="1.5" fill="#22d3ee"/></svg>
                            <h3 class="text-lg font-semibold">Dark</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Dark Template</h3>
                        <p class="text-sm text-gray-600 mb-3">Sleek, modern dark mode with neon blue accents and a glowing CTA. Perfect for night owls and techies.</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('email.campaigns.template.preview', ['campaign' => $campaign, 'template' => 'dark']) }}"
                               class="text-blue-600 hover:text-blue-800 text-sm">Preview</a>
                            <form action="{{ route('email.campaigns.template.apply', $campaign) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="template" value="dark">
                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Template 9: Playful -->
                <div class="bg-white border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-yellow-400 via-pink-400 to-blue-400 flex items-center justify-center">
                        <div class="text-center text-white">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#fbbf24" stroke="#f472b6" stroke-width="2"/><path d="M8 15c1.5 1.5 6.5 1.5 8 0" stroke="#fff" stroke-width="2" stroke-linecap="round"/><circle cx="9" cy="10" r="1.5" fill="#fff"/><circle cx="15" cy="10" r="1.5" fill="#fff"/></svg>
                            <h3 class="text-lg font-semibold">Playful</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Playful Template</h3>
                        <p class="text-sm text-gray-600 mb-3">Bright, fun colors and playful fonts. Great for creative, kids, or event campaigns.</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('email.campaigns.template.preview', ['campaign' => $campaign, 'template' => 'playful']) }}"
                               class="text-blue-600 hover:text-blue-800 text-sm">Preview</a>
                            <form action="{{ route('email.campaigns.template.apply', $campaign) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="template" value="playful">
                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 