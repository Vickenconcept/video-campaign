<nav class="fixed top-0 z-40 w-full bg-gray-50 pt-2 px-3  ">
    <div class="px-4 py-3 lg:px-6 lg:pl-3 bg-white rounded-xl shadow-sm shadow-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <!-- Mobile Sidebar Toggle -->
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-colors">
                    <span class="sr-only">Open sidebar</span>
                    <i class='bx bx-menu text-xl'></i>
                </button>
                
                <!-- Logo/Brand -->
                <a href="/home" class="flex items-center text-indigo-600 lg:w-64 ml-3 lg:ml-0">
                    <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center mr-3">
                        <i class='bx bx-video text-2xl text-white'></i>
                    </div>
                    <div>
                        <span class="font-bold text-xl text-gray-900">VidEngager</span>
                        <p class="text-xs text-gray-500 -mt-1">Video Marketing Platform</p>
                    </div>
                </a>
                
                <!-- Page Title -->
                <div class="ml-6 lg:ml-8 bg-white py-3 px-6 rounded-lg shadow-sm shadow-gray-300">
                    <h2 class="text-md font-semibold text-indigo-600 capitalize">
                        @yield('title', 'Dashboard')
                    </h2>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Notifications (Commented out for now) -->
                {{-- <button id="notification_bell" data-dropdown-toggle="dropdownNotification" 
                    class="relative inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-700 focus:outline-none bg-white p-2 rounded-lg hover:bg-gray-50 transition-colors"
                    type="button">
                    <i class='bx bx-bell text-xl'></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <div class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 border-2 border-white text-white text-xs rounded-full flex items-center justify-center">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </div>
                    @endif
                </button> --}}

                <!-- Profile Dropdown -->
                <div class="flex items-center bg-white p-2 rounded-lg shadow-sm shadow-gray-300">
                    <div class="flex items-center space-x-3" aria-expanded="false" data-dropdown-toggle="dropdown-user"
                        id="profile_avatar">
                        <button type="button" id="profile_avatar"
                            class="flex text-sm bg-gray-100 rounded-lg focus:ring-4 focus:ring-gray-200 hover:bg-gray-200 transition-colors p-2">
                            <span class="sr-only">Open user menu</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                              </svg>
                        </button>
                        
                        <!-- User Info (Hidden on mobile) -->
                        <div class="hidden md:block">
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900 capitalize">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        
                        <!-- Dropdown Arrow -->
                        <i class='bx bx-chevron-down text-gray-400 hidden md:block'></i>
                    </div>
                    
                    <!-- Profile Dropdown Menu -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg border border-gray-200 w-56"
                        id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 font-semibold" role="none">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-sm text-gray-500 truncate" role="none">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                        <ul class="py-2" role="none">
                            <li>
                                <a href="{{ route('home') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors"
                                    role="menuitem">
                                    <i class='bx bx-home-smile mr-3 text-gray-500'></i>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class='bx bx-user mr-3 text-gray-500'></i>
                                    Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('support.index') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class='bx bx-support mr-3 text-gray-500'></i>
                                    Support
                                </a>
                            </li>
                            <li class="border-t border-gray-100">
                                <a href="{{ route('auth.logout') }}"
                                    class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"
                                    role="menuitem">
                                    <i class='bx bx-log-out mr-3'></i>
                                    Sign out
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
