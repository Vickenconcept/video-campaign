<x-app-layout>
    @section('title')
        {{ 'DFY Video Agency Setup' }}
    @endsection

    <div class="max-w-7xl mx-auto pt-6 sm:px-6 lg:px-8 px-3 pb-40 overflow-y-auto h-screen">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">DFY Video Agency Setup</h1>
            <p class="text-gray-600">Complete setup and configuration for your video agency business.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Agency Setup Guide -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-4">
                        <i class='bx bx-building text-2xl text-white'></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Agency Setup Guide</h2>
                </div>
                <p class="text-gray-600 mb-4">Step-by-step guide to set up your video agency business structure.</p>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Business registration and legal setup
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Team structure and roles
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Service packages and pricing
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Client onboarding process
                    </li>
                </ul>
            </div>

            <!-- Video Production Workflow -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mr-4">
                        <i class='bx bx-video-plus text-2xl text-white'></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Video Production Workflow</h2>
                </div>
                <p class="text-gray-600 mb-4">Optimized workflow for video production and delivery.</p>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Project management system
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Client feedback integration
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Quality assurance process
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Delivery and archiving
                    </li>
                </ul>
            </div>

            <!-- Marketing Materials -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mr-4">
                        <i class='bx bx-bullhorn text-2xl text-white'></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Marketing Materials</h2>
                </div>
                <p class="text-gray-600 mb-4">Ready-to-use marketing materials for your agency.</p>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Portfolio templates
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Case study formats
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Social media content
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Email marketing sequences
                    </li>
                </ul>
            </div>

            <!-- Client Management -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-orange-600 rounded-lg flex items-center justify-center mr-4">
                        <i class='bx bx-user-check text-2xl text-white'></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Client Management</h2>
                </div>
                <p class="text-gray-600 mb-4">Systems and processes for managing client relationships.</p>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        CRM integration
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Contract templates
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Payment processing
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Support ticket system
                    </li>
                </ul>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-12 bg-gradient-to-r from-blue-600 to-purple-700 rounded-2xl p-8 text-center text-white">
            <h2 class="text-2xl font-bold mb-4">Ready to Launch Your Agency?</h2>
            <p class="text-blue-100 mb-6">Get started with our comprehensive setup guide and launch your video agency business today.</p>
            <button class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Start Setup
            </button>
        </div>
    </div>
</x-app-layout> 