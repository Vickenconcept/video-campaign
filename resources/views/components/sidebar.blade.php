<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen  transition-transform -translate-x-full bg-indigo-600  sm:translate-x-0  p-3 "
    aria-label="Sidebar">
    <div class=" h-full rounded-xl px-3 pb-4 ">
        <div class="py-5 mb-2 border-b-2 border-slate-300 flex justify-between">
            <a href="/home" class="flex items-end text-white">
                {{-- <img src="{{ asset('images/logo.svg') }}" class="h-10 me-3" alt=" Logo" /> --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                  </svg> 
                  <span style="font-family: 'Dancing Script', cursive !important;" class="font-semibold text-2xl">videngager</span>
            </a>

            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
            type="button"
            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 ">
            <span class="sr-only">Open sidebar</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
              
        </button>
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
                                class='bx bx-rectangle text-xl mr-2  group-hover:text-gray-50 group-hover:bg-indigo-600 transition duration-500 ease-in-out px-1 py-0.5 rounded-md {{ request()->routeIs('esp.connect') ? 'text-gray-50 bg-indigo-600' : 'text-indigo-600 bg-slate-50' }}'></i>
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



                </div>



                <div class="space-y-3">
                    <hr class="border border-slate-300 block ">

                    <li>
                        <a href="{{ route('support.index') }}"
                            class="flex items-center p-2 text-gray-50 hover:text-indigo-600 rounded-lg  hover:bg-gray-50 group transition duration-500 ease-in-out {{ request()->routeIs('support.index') ? 'bg-gray-50 text-indigo-600' : '' }}">
                            <i
                                class='bx bx-support text-xl mr-2  group-hover:text-gray-50 group-hover:bg-indigo-600 transition duration-500 ease-in-out px-1 py-0.5 rounded-md {{ request()->routeIs('support.index') ? 'text-gray-50 bg-indigo-600' : 'text-indigo-600 bg-slate-50' }}'></i>
                            <span class="text-sm">Support</span>
                        </a>
                    </li>


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
