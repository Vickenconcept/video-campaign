<x-app-layout>
    @section('title')
        {{ 'DFY Unlimited Traffic' }}
    @endsection

    <div class="max-w-7xl mx-auto pt-6 sm:px-6 lg:px-8 px-3 pb-40 overflow-y-auto h-screen">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">DFY Unlimited Traffic</h1>
            <p class="text-gray-600">Generate unlimited targeted traffic to your video campaigns and funnels.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Traffic Generation Strategies -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mr-4">
                        <i class='bx bx-trending-up text-2xl text-white'></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Traffic Generation Strategies</h2>
                </div>
                <p class="text-gray-600 mb-4">Proven strategies to drive unlimited traffic to your campaigns.</p>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Social media marketing
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Content marketing
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Influencer partnerships
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Paid advertising campaigns
                    </li>
                </ul>
            </div>

            <!-- Automation Tools -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-4">
                        <i class='bx bx-cog text-2xl text-white'></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Automation Tools</h2>
                </div>
                <p class="text-gray-600 mb-4">Automate your traffic generation for consistent results.</p>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Email automation
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Social media scheduling
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Lead nurturing sequences
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Retargeting campaigns
                    </li>
                </ul>
            </div>

            <!-- Analytics & Tracking -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mr-4">
                        <i class='bx bx-bar-chart-alt-2 text-2xl text-white'></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Analytics & Tracking</h2>
                </div>
                <p class="text-gray-600 mb-4">Track and optimize your traffic generation efforts.</p>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Traffic source analysis
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Conversion tracking
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        ROI measurement
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        A/B testing tools
                    </li>
                </ul>
            </div>

            <!-- Traffic Sources -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-orange-600 rounded-lg flex items-center justify-center mr-4">
                        <i class='bx bx-globe text-2xl text-white'></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Traffic Sources</h2>
                </div>
                <p class="text-gray-600 mb-4">Diversify your traffic sources for maximum reach.</p>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Organic search
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Social platforms
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Video platforms
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Guest posting
                    </li>
                </ul>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-12 bg-gradient-to-r from-green-600 to-blue-700 rounded-2xl p-8 text-center text-white">
            <h2 class="text-2xl font-bold mb-4">Start Generating Unlimited Traffic Today!</h2>
            <p class="text-green-100 mb-6">Access our comprehensive traffic generation system and start driving results immediately.</p>
            <button class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Get Started
            </button>
        </div>
    </div>
</x-app-layout> 