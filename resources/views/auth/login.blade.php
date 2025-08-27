@seo([
        'title' => 'videngager',
        'description' => 'videngager',
        'image' => asset('images/login-image.png'),
        'site_name' => config('app.name'),
        'favicon' => asset('favicon.ico'),
    ])
 <x-guest-layout>
     <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-r from-blue-400/20 to-indigo-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-r from-purple-400/20 to-pink-400/20 rounded-full blur-3xl"></div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            <!-- Enhanced Logo -->
            <div class="flex justify-center mb-6">
                <div class="w-24 h-24 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-2xl flex items-center justify-center shadow-2xl shadow-indigo-500/25 transform hover:scale-105 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-14 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                    </svg>
                </div>
            </div>
            
            <!-- Enhanced Header -->
            <div class="text-center mb-8">
                <h2 class="text-4xl font-bold text-slate-900 mb-3">
                    Welcome back
                </h2>
                <p class="text-lg text-slate-600">
                    Please sign in to your account
                </p>
            </div>
            
            <x-session-msg />
        </div>
    
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            <div class="bg-white/80 backdrop-blur-sm py-10 px-8 shadow-2xl shadow-slate-500/10 rounded-2xl border border-white/20">
                <form class="space-y-6" action="{{ route('auth.login') }}" method="post">
                    @csrf
                    
                    <!-- Enhanced Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-3 flex items-center">
                            <i class='bx bx-envelope text-indigo-600 mr-2'></i>
                            Email address
                        </label>
                        <div class="relative">
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                class="appearance-none block w-full px-4 py-3.5 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 bg-white transition-all duration-200"
                                placeholder="Enter your email">
                        </div>
                    </div>
    
                    <!-- Enhanced Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-3 flex items-center">
                            <i class='bx bx-lock text-indigo-600 mr-2'></i>
                            Password
                        </label>
                       
                        <div class="relative">
                            <input type="password"
                                class="appearance-none block w-full px-4 py-3.5 pr-12 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 bg-white transition-all duration-200"
                                placeholder="Enter password" name="password" id="password" />

                            <button type="button" onclick="showPassword()"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors duration-200 p-1 rounded-lg hover:bg-slate-100">
                                <i class="bx bx-show-alt text-xl" id="show"></i>
                                <i class="bx bx-hide text-xl" id="hide" style="display: none"></i>
                            </button>
                        </div>
                    </div>
    
                    <!-- Enhanced Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" 
                                class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded bg-white">
                            <label for="remember-me" class="ml-3 block text-sm text-slate-700 font-medium">
                                Remember me
                            </label>
                        </div>
    
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors duration-200 hover:underline">
                                Forgot password?
                            </a>
                        </div>
                    </div>
    
                    <!-- Enhanced Submit Button -->
                    <div>
                        <button type="submit" 
                            class="w-full cursor-pointer flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-base font-semibold text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-[1.02] transition-all duration-200">
                            <span class="flex items-center">
                                <span id="hiddenText" class="hidden">
                                    <i class='bx bx-loader-alt animate-spin mr-2'></i>
                                </span>
                                <span>Sign in to your account</span>
                            </span>
                        </button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

     <script>
         function showPassword() {
             var passwordField = document.getElementById('password');
             var show = document.getElementById('show');
             var hide = document.getElementById('hide');
             if (passwordField.type === 'password') {
                 passwordField.type = 'text';
                 show.style.display = 'none'
                 hide.style.display = 'block'
             } else {
                 passwordField.type = 'password';
                 show.style.display = 'block'
                 hide.style.display = 'none'
             }
         }
     </script>
 </x-guest-layout>
