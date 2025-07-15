<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-indigo-700 shadow-2xl rounded-r-2xl sm:translate-x-0 p-0 border-r border-indigo-200"
    aria-label="Sidebar">
    <div class="h-full flex flex-col rounded-r-2xl overflow-hidden">
        <!-- Branding/Header -->
        <div class="flex items-center justify-between px-5 py-4 bg-indigo-800 border-b border-indigo-300">
            <a href="/home" class="flex items-center text-white">
                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center mr-3">
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
        <div class="flex-1 overflow-y-auto py-4 px-2 bg-indigo-700">
            <ul class="font-medium flex flex-col gap-1">
                <li>
                    <a href="{{ route('tutorial') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('tutorial') ? 'bg-white text-indigo-700 shadow font-semibold' : 'text-white hover:bg-indigo-600 hover:text-white' }}">
                        <i class='bx bx-play-circle text-xl {{ request()->routeIs('tutorial') ? 'text-indigo-700' : 'text-indigo-200 group-hover:text-white' }}'></i>
                        <span class="text-sm">Tutorial</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('home') ? 'bg-white text-indigo-700 shadow font-semibold' : 'text-white hover:bg-indigo-600 hover:text-white' }}">
                        <i class="bx bx-grid-alt text-xl {{ request()->routeIs('home') ? 'text-indigo-700' : 'text-indigo-200 group-hover:text-white' }}"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('folder.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('folder.index') ? 'bg-white text-indigo-700 shadow font-semibold' : 'text-white hover:bg-indigo-600 hover:text-white' }}">
                        <i class='bx bx-folder text-xl {{ request()->routeIs('folder.index') ? 'text-indigo-700' : 'text-indigo-200 group-hover:text-white' }}'></i>
                        <span> Video Funnel </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('response.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('response.index') ? 'bg-white text-indigo-700 shadow font-semibold' : 'text-white hover:bg-indigo-600 hover:text-white' }}">
                        <i class='bx bx-message-square-detail text-xl {{ request()->routeIs('response.index') ? 'text-indigo-700' : 'text-indigo-200 group-hover:text-white' }}'></i>
                        <span>Responses</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('email.campaigns.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('email.campaigns.*') ? 'bg-white text-indigo-700 shadow font-semibold' : 'text-white hover:bg-indigo-600 hover:text-white' }}">
                        <i class='bx bx-mail-send text-xl {{ request()->routeIs('email.campaigns.*') ? 'text-indigo-700' : 'text-indigo-200 group-hover:text-white' }}'></i>
                        <span>Video Email</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('video-page.campaigns.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('video-page.campaigns.*') ? 'bg-white text-indigo-700 shadow font-semibold' : 'text-white hover:bg-indigo-600 hover:text-white' }}">
                        <i class='bx bx-layout text-xl {{ request()->routeIs('video-page.campaigns.*') ? 'text-indigo-700' : 'text-indigo-200 group-hover:text-white' }}'></i>
                        <span>Video Page</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('esp.connect') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('esp.connect') ? 'bg-white text-indigo-700 shadow font-semibold' : 'text-white hover:bg-indigo-600 hover:text-white' }}">
                        <i class='bx bx-plug text-xl {{ request()->routeIs('esp.connect') ? 'text-indigo-700' : 'text-indigo-200 group-hover:text-white' }}'></i>
                        <span>Connect ESP</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reseller.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('reseller.index') ? 'bg-white text-indigo-700 shadow font-semibold' : 'text-white hover:bg-indigo-600 hover:text-white' }}">
                        <i class='bx bx-store text-xl {{ request()->routeIs('reseller.index') ? 'text-indigo-700' : 'text-indigo-200 group-hover:text-white' }}'></i>
                        <span>Reseller</span>
                    </a>
                </li>
            </ul>
            <div class="my-4 border-t border-indigo-300"></div>
            <ul class="font-medium flex flex-col gap-1">
                <li>
                    <a href="{{ route('support.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('support.index') ? 'bg-white text-indigo-700 shadow font-semibold' : 'text-white hover:bg-indigo-600 hover:text-white' }}">
                        <i class='bx bx-support text-xl {{ request()->routeIs('support.index') ? 'text-indigo-700' : 'text-indigo-200 group-hover:text-white' }}'></i>
                        <span>Support</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('auth.logout') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group text-red-200 hover:bg-red-50 hover:text-red-700">
                        <i class='bx bx-log-out text-xl'></i>
                        <span class="text-sm capitalize">Log out</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
