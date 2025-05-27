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
            <ul class=" font-medium flex flex-col justify-between h-full">
                <div class="space-y-2">
                    <li>
                        <a href="{{ route('tutorial') }}"
                            class="flex items-center p-2 text-gray-50 hover:text-indigo-600 rounded-lg  hover:bg-gray-50 group transition duration-500 ease-in-out {{ request()->routeIs('tutorial') ? 'bg-gray-50 text-indigo-600' : '' }}">
                            <i
                                class='bx bx-video text-xl mr-2  group-hover:text-gray-50 group-hover:bg-indigo-600 transition duration-500 ease-in-out px-1 py-0.5 rounded-md {{ request()->routeIs('tutorial') ? 'text-gray-50 bg-indigo-600' : 'text-indigo-600 bg-slate-50' }}'></i>
                            <span class="text-sm">Tutorial</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}"
                            class="flex items-center p-2 text-gray-50 hover:text-indigo-600 rounded-lg  hover:bg-gray-50 group transition duration-500 ease-in-out {{ request()->routeIs('home') ? 'bg-gray-50 text-indigo-600' : '' }}">
                            <i
                                class="bx bx-home-smile text-xl mr-2  group-hover:text-gray-50 group-hover:bg-indigo-600 transition duration-500 ease-in-out px-1 py-0.5 rounded-md {{ request()->routeIs('home') ? 'text-gray-50 bg-indigo-600' : 'text-indigo-600 bg-slate-50' }}"></i>
                            <span class="">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('folder.index') }}"
                            class="flex items-center p-2 text-gray-50 hover:text-indigo-600 rounded-lg  hover:bg-gray-50 group transition duration-500 ease-in-out {{ request()->routeIs('folder.index') ? 'bg-gray-50 text-indigo-600' : '' }}">
                            <i
                                class='bx bx-folder text-xl mr-2  group-hover:text-gray-50 group-hover:bg-indigo-600 transition duration-500 ease-in-out px-1 py-0.5 rounded-md  {{ request()->routeIs('folder.index') ? 'text-gray-50 bg-indigo-600' : 'text-indigo-600 bg-slate-50' }}'></i>
                            <span class="">Folder</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('response.index') }}"
                            class="flex items-center p-2 text-gray-50 hover:text-indigo-600 rounded-lg  hover:bg-gray-50 group transition duration-500 ease-in-out {{ request()->routeIs('response.index') ? 'bg-gray-50 text-indigo-600' : '' }}">
                            <i
                                class='bx bx-message text-xl mr-2  group-hover:text-gray-50 group-hover:bg-indigo-600 transition duration-500 ease-in-out px-1 py-0.5 rounded-md  rounded-md {{ request()->routeIs('response.index') ? 'text-gray-50 bg-indigo-600' : 'text-indigo-600 bg-slate-50' }}'></i>
                            <span class="">Responses</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('esp.connect') }}"
                            class="flex items-center p-2 text-gray-50 hover:text-indigo-600 rounded-lg  hover:bg-gray-50 group transition duration-500 ease-in-out {{ request()->routeIs('esp.connect') ? 'bg-gray-50 text-indigo-600' : '' }}">
                            <i
                                class='bx bx-home-smile text-xl mr-2  group-hover:text-gray-50 group-hover:bg-indigo-600 transition duration-500 ease-in-out px-1 py-0.5 rounded-md {{ request()->routeIs('esp.connect') ? 'text-gray-50 bg-indigo-600' : 'text-indigo-600 bg-slate-50' }}'></i>
                            <span class="">Connect ESP</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('reseller.index') }}"
                            class="flex items-center p-2 text-gray-50 hover:text-indigo-600 rounded-lg  hover:bg-gray-50 group transition duration-500 ease-in-out {{ request()->routeIs('reseller.index') ? 'bg-gray-50 text-indigo-600' : '' }}">
                            <i
                                class='bx bx-refresh text-xl mr-2  group-hover:text-gray-50 group-hover:bg-indigo-600 transition duration-500 ease-in-out px-1 py-0.5 rounded-md {{ request()->routeIs('reseller.index') ? 'text-gray-50 bg-indigo-600' : 'text-indigo-600 bg-slate-50' }}'></i>
                            <span class="text-sm">Reseller</span>
                        </a>
                    </li>


                    <li>
                        <a href="{{ route('support.index') }}"
                            class="flex items-center p-2 text-gray-50 hover:text-indigo-600 rounded-lg  hover:bg-gray-50 group transition duration-500 ease-in-out {{ request()->routeIs('support.index') ? 'bg-gray-50 text-indigo-600' : '' }}">
                            <i
                                class='bx bx-video text-xl mr-2  group-hover:text-gray-50 group-hover:bg-indigo-600 transition duration-500 ease-in-out px-1 py-0.5 rounded-md {{ request()->routeIs('support.index') ? 'text-gray-50 bg-indigo-600' : 'text-indigo-600 bg-slate-50' }}'></i>
                            <span class="text-sm">Support</span>
                        </a>
                    </li>
                </div>



                <div class="spacec-y-2">
                    <hr class="border border-slate-300">


                    <li class="">
                        <a href="{{ route('auth.logout') }}"
                            class="flex items-center p-2 text-gray-50 hover:text-indigo-600 rounded-lg  hover:bg-gray-50 group transition duration-500 ease-in-out">
                            <i
                                class='bx bx-exit text-xl mr-2 text-indigo-600 bg-slate-50 group-hover:text-gray-50 group-hover:bg-indigo-600 transition duration-500 ease-in-out px-1 py-0.5 rounded-md'></i>
                            <span class="text-sm capitalize">Log out</span>
                        </a>
                    </li>
                </div>
            </ul>
        </div>
    </div>
</aside>
