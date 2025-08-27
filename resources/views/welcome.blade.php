<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Video Campaign - Create Engaging Video Experiences</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 text-slate-900 dark:text-slate-100 min-h-screen">
        <!-- Navigation -->
        <nav class="absolute top-0 left-0 right-0 z-50 p-6">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class='bx bx-video text-white text-xl'></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">VideoCampaign</span>
                </div>
                
                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-white/10 backdrop-blur-md border border-white/20 text-white px-6 py-2 rounded-lg hover:bg-white/20 transition-all duration-300">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-white/80 hover:text-white transition-colors duration-300">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-white text-slate-900 px-6 py-2 rounded-lg hover:bg-slate-100 transition-all duration-300 font-medium">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 px-6">
            <div class="max-w-7xl mx-auto text-center">
                <!-- Background Elements -->
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-blue-400/20 to-indigo-400/20 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-r from-purple-400/20 to-pink-400/20 rounded-full blur-3xl"></div>
                </div>
                
                <!-- Main Content -->
                <div class="relative z-10">
                    <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                        <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            Create Engaging
                        </span>
                        <br>
                        <span class="text-slate-800 dark:text-slate-200">Video Campaigns</span>
                    </h1>
                    
                    <p class="text-xl md:text-2xl text-slate-600 dark:text-slate-400 mb-8 max-w-3xl mx-auto leading-relaxed">
                        Transform your marketing with interactive video experiences. Create, manage, and track engaging video campaigns that convert.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-8 py-4 rounded-xl text-lg font-semibold shadow-2xl hover:shadow-blue-500/25 transition-all duration-300 transform hover:scale-105">
                            Start Free Trial
                        </a>
                        <a href="#features" class="bg-white/10 backdrop-blur-md border border-white/20 text-slate-700 dark:text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-white/20 transition-all duration-300">
                            Learn More
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 mb-2">10K+</div>
                            <div class="text-slate-600 dark:text-slate-400">Active Campaigns</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-indigo-600 mb-2">95%</div>
                            <div class="text-slate-600 dark:text-slate-400">Engagement Rate</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600 mb-2">24/7</div>
                            <div class="text-slate-600 dark:text-slate-400">Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 px-6 bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">
                        <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Powerful Features
                        </span>
                    </h2>
                    <p class="text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                        Everything you need to create, manage, and optimize your video campaigns
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:shadow-2xl transition-all duration-300 group">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class='bx bx-video-plus text-white text-2xl'></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-4 text-slate-800 dark:text-slate-200">Video Creation</h3>
                        <p class="text-slate-600 dark:text-slate-400">Create stunning video campaigns with our intuitive editor and templates.</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:shadow-2xl transition-all duration-300 group">
                        <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class='bx bx-analytics text-white text-2xl'></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-4 text-slate-800 dark:text-slate-200">Analytics & Tracking</h3>
                        <p class="text-slate-600 dark:text-slate-400">Track performance, engagement, and conversions with detailed analytics.</p>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:shadow-2xl transition-all duration-300 group">
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class='bx bx-share text-white text-2xl'></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-4 text-slate-800 dark:text-slate-200">Easy Sharing</h3>
                        <p class="text-slate-600 dark:text-slate-400">Share your campaigns across multiple platforms with one click.</p>
                    </div>
                    
                    <!-- Feature 4 -->
                    <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:shadow-2xl transition-all duration-300 group">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class='bx bx-folder text-white text-2xl'></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-4 text-slate-800 dark:text-slate-200">Campaign Management</h3>
                        <p class="text-slate-600 dark:text-slate-400">Organize and manage all your campaigns in one centralized dashboard.</p>
                    </div>
                    
                    <!-- Feature 5 -->
                    <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:shadow-2xl transition-all duration-300 group">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class='bx bx-envelope text-white text-2xl'></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-4 text-slate-800 dark:text-slate-200">Email Integration</h3>
                        <p class="text-slate-600 dark:text-slate-400">Integrate with popular email service providers for seamless campaigns.</p>
                    </div>
                    
                    <!-- Feature 6 -->
                    <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:shadow-2xl transition-all duration-300 group">
                        <div class="w-16 h-16 bg-gradient-to-r from-pink-500 to-pink-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class='bx bx-mobile text-white text-2xl'></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-4 text-slate-800 dark:text-slate-200">Mobile Optimized</h3>
                        <p class="text-slate-600 dark:text-slate-400">Perfect viewing experience on all devices and screen sizes.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Ready to Transform Your Marketing?
                </h2>
                <p class="text-xl text-slate-600 dark:text-slate-400 mb-8">
                    Join thousands of marketers who are already using VideoCampaign to boost their engagement and conversions.
                </p>
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-10 py-4 rounded-xl text-xl font-semibold shadow-2xl hover:shadow-blue-500/25 transition-all duration-300 transform hover:scale-105 inline-block">
                    Get Started Today
                </a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-400 py-12 px-6">
            <div class="max-w-7xl mx-auto text-center">
                <div class="flex items-center justify-center space-x-2 mb-6">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                        <i class='bx bx-video text-white text-sm'></i>
                    </div>
                    <span class="text-lg font-bold text-white">VideoCampaign</span>
                </div>
                <p class="text-slate-400 mb-4">
                    © 2024 VideoCampaign. All rights reserved.
                </p>
                <div class="flex items-center justify-center space-x-6 text-sm">
                    <a href="#" class="hover:text-white transition-colors duration-300">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors duration-300">Terms of Service</a>
                    <a href="#" class="hover:text-white transition-colors duration-300">Support</a>
                </div>
            </div>
        </footer>
    </body>
</html>
