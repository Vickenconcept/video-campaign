<div class="min-h-screen bg-gray-50 py-8 h-screen overflow-y-auto pb-40">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Brand Settings</h1>
            <p class="mt-2 text-gray-600">Customize your brand information for email campaigns and communications.</p>
        </div>

        @if (session()->has('message'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <form wire:submit.prevent="save">
                        <!-- Basic Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="brand_name" class="block text-sm font-medium text-gray-700 mb-2">Brand
                                        Name</label>
                                    <input type="text" id="brand_name" wire:model="brand_name"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Your brand name">
                                    @error('brand_name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" id="email" wire:model="email"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="contact@yourcompany.com">
                                    @error('email')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>


                            </div>

                            <div class="mt-4">
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <textarea id="address" wire:model="address" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Your business address"></textarea>
                                @error('address')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="phone"
                                        class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                    <input type="text" id="phone" wire:model="phone"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="+1 (555) 123-4567">
                                    @error('phone')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div>
                                    <label for="website"
                                        class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                                    <input type="url" id="website" wire:model="website"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="https://yourcompany.com">
                                    @error('website')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Branding -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Branding</h3>

                            <div class="mb-4">
                                <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                                <input type="file" id="logo" wire:model="logo" accept="image/*"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('logo')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                                @if ($logo_url)
                                    <div class="mt-2">
                                        <img src="{{ $logo_url }}" alt="Current logo" class="h-16 w-auto">
                                    </div>
                                @endif
                            </div>
                        </div>



                        <!-- Settings -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Settings</h3>

                            <div class="flex items-center">
                                <input type="checkbox" id="is_active" wire:model="is_active"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                    Use custom branding in emails
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4">
                            <button type="button" wire:click="togglePreview"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Preview
                            </button>
                            <button type="submit"
                                wire:loading.attr="disabled"
                                wire:target="save"
                                class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center justify-center">
                                <span wire:loading.remove wire:target="save">Save Settings</span>
                                <span wire:loading wire:target="save" class="flex items-center">
                                    <svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                   <span> Saving...</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview</h3>

                    @if ($showPreview)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="text-center mb-4">
                                @if ($logo_url)
                                    <img src="{{ $logo_url }}" alt="Brand logo" class="h-12 w-auto mx-auto mb-2">
                                @endif
                                <h4 class="text-lg font-semibold text-gray-900">{{ $brand_name ?: 'Your Brand' }}</h4>
                            </div>

                            <div class="space-y-2 text-sm text-gray-600">
                                @if ($address)
                                    <p>{{ $address }}</p>
                                @endif
                                @if ($phone)
                                    <p>Phone: {{ $phone }}</p>
                                @endif
                                @if ($email)
                                    <p>Email: {{ $email }}</p>
                                @endif
                                @if ($website)
                                    <p>Website: {{ $website }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center text-gray-500">
                            <p>Click "Preview" to see how your brand will appear in emails.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
