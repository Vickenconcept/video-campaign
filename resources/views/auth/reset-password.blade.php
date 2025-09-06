<x-guest-layout>
    <div class="flex justify-center items-center h-screen bg-white">
        <div class="lg:w-[40%] w-full mx-auto">
            <form method="POST" action="{{ route('password.update') }}"
                class="shadow-md rounded-2xl bg-sgray-50 px-8 pt-6 pb-8 mb-4">
                @csrf
                <h4 class="text-3xl text-center">Reset Password</h4>
                <div class="my-4">
                    @if ($errors->any())
                        <div class="bg-red-200 text-red-500 p-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="bg-green-200 text-green-500 p-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mt-4">
                        <div class="flex items-center justify-between">
                            <label for="password_confirmation" class="input-label">Email</label>
                        </div>

                        <input id="email" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="email" name="email" required
                            autocomplete="current-email" placeholder="Enter your email address" />

                    </div>
                    <div class="mt-4">
                        <div class="flex items-center justify-between">
                            <label for="password_confirmation" class="input-label">Password </label>
                        </div>

                        <input id="password" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="password" name="password" required
                            autocomplete="current-password" placeholder="Enter your password " />

                    </div>
                    <div class="mt-4">
                        <div class="flex items-center justify-between">
                            <label for="password_confirmation" class="input-label">Password Confirmation</label>
                        </div>
                        <div class="">
                            <input id="password_confirmation" name="password_confirmation" type="password" placeholder="*****"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="">
                        <input id="token" name="token" type="hidden" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            value="{{ $token }}">
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-900 hover:shadow px-4 py-1.5 font-semibold text-blue-50 rounded-md w-full transition duration-500 ease-in-out">
                            <span id="hiddenText" class="hidden"> <i class='bx bx-loader-alt animate-spin'></i></span>
                            <span>RESET</span>
                        </button>
                    </div>
            </form>
        </div>
    </div>
   
</x-guest-layout>
