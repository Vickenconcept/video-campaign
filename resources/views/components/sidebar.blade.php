<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen  transition-transform -translate-x-full bg-indigo-600  sm:translate-x-0  p-3 "
    aria-label="Sidebar">
    <div class=" h-full rounded-xl px-3 pb-4 ">
        <div class="py-5 mb-2 border-b-2 border-slate-300">
            <a href="/home" class="">
                <img src="{{ asset('images/logo.svg') }}" class="h-10 me-3" alt="FluenceGrid Logo" />
            </a>
        </div>
        <div class="h-[85%] pb-4 overflow-y-auto ">
            <ul class="space-y-1 font-medium">
                <li>
                    <a href="{{ route('home') }}"
                        class="flex items-center p-2 text-gray-50 rounded-lg  hover:bg-gray-500/40 group transition duration-500 ease-in-out {{ request()->routeIs('home') ? 'bg-gray-500/40' : '' }}">
                        <i class='bx bx-home-smile text-xl mr-2 text-blue-600 bg-slate-200 px-1 py-0.5 rounded-md'></i>
                        <span class="">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('folder.index') }}"
                        class="flex items-center p-2 text-gray-50 rounded-lg  hover:bg-gray-500/40 group transition duration-500 ease-in-out {{ request()->routeIs('folder.index') ? 'bg-gray-500/40' : '' }}">
                        <i class='bx bx-home-smile text-xl mr-2 text-blue-600 bg-slate-200 px-1 py-0.5 rounded-md'></i>
                        <span class="">Folder</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('response.index') }}"
                        class="flex items-center p-2 text-gray-50 rounded-lg  hover:bg-gray-500/40 group transition duration-500 ease-in-out {{ request()->routeIs('response.index') ? 'bg-gray-500/40' : '' }}">
                        <i class='bx bx-home-smile text-xl mr-2 text-blue-600 bg-slate-200 px-1 py-0.5 rounded-md'></i>
                        <span class="">Responses</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('esp.connect') }}"
                        class="flex items-center p-2 text-gray-50 rounded-lg  hover:bg-gray-500/40 group transition duration-500 ease-in-out {{ request()->routeIs('esp.connect') ? 'bg-gray-500/40' : '' }}">
                        <i class='bx bx-home-smile text-xl mr-2 text-blue-600 bg-slate-200 px-1 py-0.5 rounded-md'></i>
                        <span class="">Connect ESP</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('reseller.index') }}"
                        class="flex items-center p-2 text-gray-50 rounded-lg  hover:bg-gray-500/40 group transition duration-500 ease-in-out {{ request()->routeIs('reseller.index') ? 'bg-gray-500/40' : '' }}">
                        <i class='bx bx-refresh text-xl mr-2 text-blue-600 bg-slate-200 px-1 py-0.5 rounded-md'></i>
                        <span class="text-sm">Reseller</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('tutorial') }}"
                        class="flex items-center p-2 text-gray-50 rounded-lg  hover:bg-gray-500/40 group transition duration-500 ease-in-out {{ request()->routeIs('tutorial') ? 'bg-gray-500/40' : '' }}">
                        <i class='bx bx-refresh text-xl mr-2 text-blue-600 bg-slate-200 px-1 py-0.5 rounded-md'></i>
                        <span class="text-sm">Tutorial</span>
                    </a>
                </li>


                {{-- <li>
                    <a href="{{ route('groups.index') }}"
                        class="flex items-center p-2 text-gray-50 rounded-lg  hover:bg-gray-500/40 group transition duration-500 ease-in-out {{ request()->routeIs('groups.index') ? 'bg-gray-500/40' : '' }}">
                        <i class='bx bx-folder text-xl mr-2 text-blue-600 bg-slate-200 px-1 py-0.5 rounded-md'></i>
                        <span class="text-sm">Groups</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('campaigns.index') }}"
                        class="flex items-center p-2 text-gray-50 rounded-lg  hover:bg-gray-500/40 group transition duration-500 ease-in-out {{ request()->routeIs('campaigns.index') ? 'bg-gray-500/40' : '' }}">
                        <i class='bx bxs-building text-xl mr-2 text-blue-600 bg-slate-200 px-1 py-0.5 rounded-md'></i>
                        <span class="text-sm">Campaign</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('campaigns.response') }}"
                        class="flex items-center p-2 text-gray-50 rounded-lg  hover:bg-gray-500/40 group transition duration-500 ease-in-out {{ request()->routeIs('campaigns.response') ? 'bg-gray-500/40' : '' }}">
                        <i class='bx bxs-chat text-xl mr-2 text-blue-600 bg-slate-200 px-1 py-0.5 rounded-md'></i>
                        <span class="text-sm">Responses</span>
                    </a>
                </li> --}}
                <hr class="border border-slate-300">
               
               
                <li class="">
                    <a href="{{ route('auth.logout') }}"
                        class="flex items-center p-2 text-gray-50 rounded-lg  hover:bg-gray-500/40 group transition duration-500 ease-in-out">
                        <i class='bx bx-exit text-xl mr-2 text-blue-600 bg-slate-200 px-1 py-0.5 rounded-md'></i>
                        <span class="text-sm capitalize">Log out</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
