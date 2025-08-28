<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-white shadow-2xl rounded-r-2xl sm:translate-x-0 p-0 "
    aria-label="Sidebar">
    <div class="h-full flex flex-col rounded-r-2xl overflow-hidden">
        <!-- Branding/Header -->
        <div class="flex items-center justify-between px-5 py-8 bg-white border-b border-indigo-300">
            <a href="/home"
                class="flex items-center text-indigo-700  bg-white rounded-xl py-4 px-4 hover:bg-indigo-100 transition-all duration-200 shadow-lg shadow-gray-400/70 border border-gray-200">
                <div class="w-10 h-10 bg-indigo-600 rounded-2xl flex items-center justify-center mr-3">
                    <i class='bx bx-video text-2xl text-white'></i>
                </div>
                <span class="font-bold text-xl tracking-wide">VidEngager</span>
            </a>
            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                type="button"
                class="inline-flex items-center p-2 text-white rounded-lg sm:hidden hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition-colors">
                <span class="sr-only">Close sidebar</span>
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>
        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto py-4 px-2 bg-white">
            <ul class="font-medium flex flex-col gap-3">
                <li>
                    <a href="{{ route('tutorial') }}"
                        class="flex items-center gap-2 px-4 py-4 rounded-lg transition-colors group {{ request()->routeIs('tutorial') ? 'bg-gradient-to-r from-indigo-500 to-indigo-700 text-white shadow font-semibold' : 'text-gray-700 hover:shadow-lg hover:text-indigo-700' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="size-8 p-1 rounded-lg  {{ request()->routeIs('tutorial') ? 'text-white bg-white/20' : 'text-indigo-700  bg-gradient-to-r from-indigo-100 to-indigo-200' }}">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" />
                        </svg>

                        <span class="text-md">Tutorial</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-2 px-4 py-4 rounded-lg transition-colors group {{ request()->routeIs('home') ? 'bg-gradient-to-r from-indigo-500 to-indigo-700 text-white shadow font-semibold' : 'text-gray-700 hover:shadow-lg hover:text-indigo-700' }}">
                        <i
                            class="bx bx-grid-alt size-8 p-1 rounded-lg {{ request()->routeIs('home') ? 'text-white bg-white/20' : 'text-indigo-700 bg-gradient-to-r from-indigo-100 to-indigo-200' }}"></i>
                        <span class="text-md">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('folder.index') }}"
                        class="flex items-center gap-2 px-4 py-4 rounded-lg transition-colors group {{ request()->routeIs('folder.index') ? 'bg-gradient-to-r from-green-500 to-green-700 text-white shadow font-semibold' : 'text-gray-700 hover:shadow-lg hover:text-green-700' }}">
                        <i
                            class='bx bx-folder size-8 p-1 rounded-lg {{ request()->routeIs('folder.index') ? 'text-white bg-white/20' : 'text-green-700 bg-gradient-to-r from-green-100 to-green-200' }}'></i>
                        <span class="text-md">Video Funnel</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('response.index') }}"
                        class="flex items-center gap-2 px-4 py-4 rounded-lg transition-colors group {{ request()->routeIs('response.index') ? 'bg-gradient-to-r from-orange-500 to-orange-700 text-white shadow font-semibold' : 'text-gray-700 hover:shadow-lg hover:text-orange-700' }}">
                        <i
                            class='bx bx-message-square-detail size-8 p-1 rounded-lg {{ request()->routeIs('response.index') ? 'text-white bg-white/20' : 'text-orange-700 bg-gradient-to-r from-orange-100 to-orange-200' }}'></i>
                        <span class="text-md">Responses</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('email.campaigns.index') }}"
                        class="flex items-center gap-2 px-4 py-4 rounded-lg transition-colors group {{ request()->routeIs('email.campaigns.*') ? 'bg-gradient-to-r from-blue-500 to-blue-700 text-white shadow font-semibold' : 'text-gray-700 hover:shadow-lg hover:text-blue-700' }}">
                        <i
                            class='bx bx-mail-send size-8 p-1 rounded-lg {{ request()->routeIs('email.campaigns.*') ? 'text-white bg-white/20' : 'text-blue-700 bg-gradient-to-r from-blue-100 to-blue-200' }}'></i>
                        <span class="text-md">Video Email</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('video-page.campaigns.index') }}"
                        class="flex items-center gap-2 px-4 py-4 rounded-lg transition-colors group {{ request()->routeIs('video-page.campaigns.*') ? 'bg-gradient-to-r from-purple-500 to-purple-700 text-white shadow font-semibold' : 'text-gray-700 hover:shadow-lg hover:text-purple-700' }}">
                        <i
                            class='bx bx-layout size-8 p-1 rounded-lg {{ request()->routeIs('video-page.campaigns.*') ? 'text-white bg-white/20' : 'text-purple-700 bg-gradient-to-r from-purple-100 to-purple-200' }}'></i>
                        <span class="text-md">Video Page</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('esp.connect') }}"
                        class="flex items-center gap-2 px-4 py-4 rounded-lg transition-colors group {{ request()->routeIs('esp.connect') ? 'bg-gradient-to-r from-teal-500 to-teal-700 text-white shadow font-semibold' : 'text-gray-700 hover:shadow-lg hover:text-teal-700' }}">
                        <i
                            class='bx bx-plug size-8 p-1 rounded-lg {{ request()->routeIs('esp.connect') ? 'text-white bg-white/20' : 'text-teal-700 bg-gradient-to-r from-teal-100 to-teal-200' }}'></i>
                        <span class="text-md">Connect ESP</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reseller.index') }}"
                        class="flex items-center gap-2 px-4 py-4 rounded-lg transition-colors group {{ request()->routeIs('reseller.index') ? 'bg-gradient-to-r from-amber-500 to-amber-700 text-white shadow font-semibold' : 'text-gray-700 hover:shadow-lg hover:text-amber-700' }}">
                        <i
                            class='bx bx-store size-8 p-1 rounded-lg {{ request()->routeIs('reseller.index') ? 'text-white bg-white/20' : 'text-amber-700 bg-gradient-to-r from-amber-100 to-amber-200' }}'></i>
                        <span class="text-md">Reseller</span>
                    </a>
                </li>

                {{-- DFY Video Agency Setup - OTO2 Products --}}
                @role('OTO2')
                <li>
                    <a href="{{ route('dfy_video_agency_setup.index') }}"
                        class="flex items-center gap-2 px-4 py-4 rounded-lg transition-colors group {{ request()->routeIs('dfy_video_agency_setup.index') ? 'bg-gradient-to-r from-indigo-500 to-indigo-700 text-white shadow font-semibold' : 'text-gray-700 hover:shadow-lg hover:text-indigo-700' }}">
                        <i
                            class='bx bx-building size-8 p-1 rounded-lg {{ request()->routeIs('dfy_video_agency_setup.index') ? 'text-white bg-white/20' : 'text-indigo-700 bg-gradient-to-r from-indigo-100 to-indigo-200' }}'></i>
                        <span class="text-md">DFY Video Agency Setup</span>
                    </a>
                </li>
                @endrole

                {{-- DFY Unlimited Traffic - OTO3 Products --}}
                @role('OTO3')
                <li>
                    <a href="{{ route('dfy_unlimited_traffic.index') }}"
                        class="flex items-center gap-2 px-4 py-4 rounded-lg transition-colors group {{ request()->routeIs('dfy_unlimited_traffic.index') ? 'bg-gradient-to-r from-green-500 to-green-700 text-white shadow font-semibold' : 'text-gray-700 hover:shadow-lg hover:text-green-700' }}">
                        <i
                            class='bx bx-trending-up size-8 p-1 rounded-lg {{ request()->routeIs('dfy_unlimited_traffic.index') ? 'text-white bg-white/20' : 'text-green-700 bg-gradient-to-r from-green-100 to-green-200' }}'></i>
                        <span class="text-md">DFY Unlimited Traffic</span>
                    </a>
                </li>
                @endrole

                {{-- Affiliate Marketing Training - OTO5 Products --}}
                @role('OTO5')
                <li>
                    <a href="{{ route('affiliate_marketing_training.index') }}"
                        class="flex items-center gap-2 px-4 py-4 rounded-lg transition-colors group {{ request()->routeIs('affiliate_marketing_training.index') ? 'bg-gradient-to-r from-purple-500 to-purple-700 text-white shadow font-semibold' : 'text-gray-700 hover:shadow-lg hover:text-purple-700' }}">
                        <i
                            class='bx bx-book-open size-8 p-1 rounded-lg {{ request()->routeIs('affiliate_marketing_training.index') ? 'text-white bg-white/20' : 'text-purple-700 bg-gradient-to-r from-purple-100 to-purple-200' }}'></i>
                        <span class="text-md">Affiliate Marketing Training</span>
                    </a>
                </li>
                @endrole
            </ul>
            <div class="my-4 border-t border-indigo-300"></div>
            <ul class="font-medium flex flex-col gap-1">
                <li>
                    <a href="{{ route('support.index') }}"
                        class="flex items-center gap-2 px-4 py-4 rounded-lg transition-colors group {{ request()->routeIs('support.index') ? 'bg-gradient-to-r from-rose-500 to-rose-700 text-white shadow font-semibold' : 'text-gray-700 hover:shadow-lg hover:text-rose-700' }}">
                        <i
                            class='bx bx-support size-8 p-1 rounded-lg {{ request()->routeIs('support.index') ? 'text-white bg-white/20' : 'text-rose-700 bg-gradient-to-r from-rose-100 to-rose-200' }}'></i>
                        <span class="text-md">Support</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Fixed Bottom Section -->
        <div class="border-t border-indigo-300 bg-white px-2 py-4">
            <ul class="font-medium flex flex-col gap-1">
                <li>
                    <a href="{{ route('auth.logout') }}"
                        class="flex items-center gap-2 px-4 py-4 rounded-lg transition-colors group text-gray-700 hover:shadow-lg hover:text-red-700">
                        <i class='bx bx-log-out size-8 p-1 rounded-lg bg-gradient-to-r from-red-100 to-red-200 text-red-700'></i>
                        <span class="text-md capitalize">Log out</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
