<x-app-layout>
    @section('title')
        {{ 'reseller' }}
    @endsection
    <div x-data="{ openModal: false }" class="px-3 pb-32 overflow-y-auto h-screen pt-5">
        <!-- Enhanced Header Section -->
        <div class="bg-gradient-to-r from-purple-50 to-white rounded-xl p-6 shadow-2xl shadow-purple-500/20 border border-purple-200 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Reseller Dashboard</h1>
                    <p class="text-gray-600">Manage and register new users for your reseller business</p>
                </div>
                <div class="mb-8">
                    <button class="bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer flex items-center gap-2" @click="openModal = true">
                        <i class="bx bx-plus text-lg"></i>
                        <span>Register User</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Enhanced Session Messages -->
        <div class="mb-6">
            <x-session-msg />
        </div>

        <!-- Enhanced Users Section -->
        <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b border-purple-200">
                <h2 class="text-xl font-semibold text-purple-900">Users Management</h2>
                <p class="text-purple-700 text-sm">View and manage all registered users</p>
            </div>
            <div class="p-6">
                <livewire:resell-table />
            </div>
        </div>

        {{-- Enhanced Modal --}}
        <div class="fixed items-center justify-center flex top-0 left-0 mx-auto w-full h-full bg-gray-600/50 z-50 transition duration-300 ease-in-out"
            x-show="openModal" style="display: none;">
            <div @click.away="openModal = false"
                class="bg-white w-[90%] md:w-[70%] lg:w-[50%] xl:w-[40%] shadow-2xl rounded-xl overflow-hidden transition-all relative duration-300">
                
                <!-- Enhanced Modal Header -->
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b border-purple-200">
                    <div class="flex justify-between items-center w-full">
                        <h4 class="text-lg font-semibold text-purple-900 flex items-center gap-2">
                            <i class='bx bx-user-plus text-purple-600'></i>
                            Create New User
                        </h4>
                        <button type="button" @click="openModal = false" class="text-purple-600 hover:text-purple-800 hover:bg-purple-200 p-2 rounded-lg transition-all duration-200 cursor-pointer">
                            <i class="bx bx-x font-medium text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Enhanced Modal Body -->
                <div class="p-6">
                    <form class="space-y-6" action="{{ route('reseller.store') }}" method="POST">
                        @csrf
                        
                        <!-- Enhanced Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <div class="relative">
                                <i class='bx bx-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                                <input id="name" name="name" value="{{ old('name') }}" type="text"
                                    autocomplete="name" 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200" 
                                    placeholder="Smith Joe">
                            </div>
                            @error('name')
                                <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                    <i class='bx bx-error-circle'></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Enhanced Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <div class="relative">
                                <i class='bx bx-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                                <input id="email" name="email" value="{{ old('email') }}" type="email"
                                    autocomplete="email" 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200" 
                                    placeholder="example@gmail.com">
                            </div>
                            @error('email')
                                <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                    <i class='bx bx-error-circle'></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Enhanced Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <i class='bx bx-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                                <input id="password" name="password" type="password" autocomplete="new-password"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200" 
                                    placeholder="********">
                            </div>
                            @error('password')
                                <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                    <i class='bx bx-error-circle'></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Enhanced Password Confirmation Field -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                            <div class="relative">
                                <i class='bx bx-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    autocomplete="new-password"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200" 
                                    placeholder="********">
                            </div>
                        </div>

                        <!-- Enhanced Submit Button -->
                        <div class="pt-4 border-t border-gray-200">
                            <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer flex items-center justify-center gap-2">
                                <i class='bx bx-user-plus text-lg'></i>
                                <span>Create User</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
