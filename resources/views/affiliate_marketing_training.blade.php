<x-app-layout>
    @section('title')
        {{ 'Affiliate Marketing Training' }}
    @endsection

    <div class="max-w-7xl mx-auto pt-6 sm:px-6 lg:px-8 px-3 pb-40 overflow-y-auto h-screen">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Affiliate Marketing Training</h1>
            <p class="text-gray-600">Master the art of affiliate marketing and build a profitable online business.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Fundamentals Course -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-4">
                        <i class='bx bx-book-open text-2xl text-white'></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Fundamentals Course</h2>
                </div>
                <p class="text-gray-600 mb-4">Learn the basics of affiliate marketing from the ground up.</p>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Understanding affiliate marketing
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Choosing profitable niches
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Finding affiliate programs
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Building your audience
                    </li>
                </ul>
            </div>

            <!-- Advanced Strategies -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mr-4">
                        <i class='bx bx-target-lock text-2xl text-white'></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Advanced Strategies</h2>
                </div>
                <p class="text-gray-600 mb-4">Take your affiliate marketing to the next level.</p>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Conversion optimization
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Email marketing mastery
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Social media strategies
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Scaling your business
                    </li>
                </ul>
            </div>

            <!-- Tools & Resources -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mr-4">
                        <i class='bx bx-wrench text-2xl text-white'></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Tools & Resources</h2>
                </div>
                <p class="text-gray-600 mb-4">Essential tools to streamline your affiliate marketing.</p>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Tracking and analytics
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Content creation tools
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Automation platforms
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Landing page builders
                    </li>
                </ul>
            </div>

            <!-- Case Studies -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-orange-600 rounded-lg flex items-center justify-center mr-4">
                        <i class='bx bx-trophy text-2xl text-white'></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Case Studies</h2>
                </div>
                <p class="text-gray-600 mb-4">Real-world examples of successful affiliate marketers.</p>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Success stories
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Strategy breakdowns
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Income reports
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-check text-green-500 mr-2'></i>
                        Lessons learned
                    </li>
                </ul>
            </div>
        </div>

        <!-- Course Progress -->
        <div class="mt-12 bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Your Learning Progress</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">75%</span>
                    </div>
                    <h3 class="font-semibold text-gray-900">Course Completion</h3>
                    <p class="text-sm text-gray-600">3 of 4 modules completed</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">12</span>
                    </div>
                    <h3 class="font-semibold text-gray-900">Lessons Completed</h3>
                    <p class="text-sm text-gray-600">Out of 16 total lessons</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-purple-600">85%</span>
                    </div>
                    <h3 class="font-semibold text-gray-900">Quiz Score</h3>
                    <p class="text-sm text-gray-600">Average across all quizzes</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-12 bg-gradient-to-r from-blue-600 to-purple-700 rounded-2xl p-8 text-center text-white">
            <h2 class="text-2xl font-bold mb-4">Ready to Start Your Affiliate Marketing Journey?</h2>
            <p class="text-blue-100 mb-6">Access our comprehensive training program and start building your affiliate business today.</p>
            <button class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Continue Learning
            </button>
        </div>
    </div>
</x-app-layout> 