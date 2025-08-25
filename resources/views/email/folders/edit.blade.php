<x-app-layout>
    <div class="container mx-auto px-4 py-8 pt-5 pb-32 overflow-y-auto h-screen">
        <div class="max-w-2xl mx-auto">
            <!-- Enhanced Header Section -->
            <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-6 shadow-2xl shadow-gray-500/20 border border-gray-200 mb-8">
                <div class=" space-y-4 sm:space-y-0">
                    <a href="{{ route('email.folders.index') }}" 
                       class="text-gray-600 hover:text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg transition-all duration-200 flex items-center gap-2">
                        <i class='bx bx-arrow-back text-lg'></i>
                        <span>Back to Folders</span>
                    </a>
                    <div class="flex-1 text-center sm:text-left">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Folder</h1>
                        <p class="text-gray-600">Update your folder information and settings</p>
                    </div>
                </div>
            </div>

            <!-- Enhanced Form Container -->
            <div class="bg-white shadow-xl rounded-xl border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 border-b border-green-200">
                    <h2 class="text-lg font-semibold text-green-900">Folder Information</h2>
                    <p class="text-green-700 text-sm">Modify the details below to update your folder</p>
                </div>
                
                <form action="{{ route('email.folders.update', $folder) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Enhanced Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">Folder Name</label>
                            <div class="relative">
                                <i class='bx bx-folder absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $folder->name) }}" 
                                       required
                                       placeholder="Enter folder name..."
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-gray-900">
                            </div>
                            @error('name')
                                <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                    <i class='bx bx-error-circle'></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Enhanced Description Field -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">Description (Optional)</label>
                            <div class="relative">
                                <i class='bx bx-text absolute left-3 top-4 text-gray-400'></i>
                                <textarea name="description" 
                                          id="description" 
                                          rows="3"
                                          placeholder="Describe what this folder contains..."
                                          class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-gray-900 resize-none">{{ old('description', $folder->description) }}</textarea>
                            </div>
                            @error('description')
                                <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                    <i class='bx bx-error-circle'></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Enhanced Color Field -->
                        <div>
                            <label for="color" class="block text-sm font-semibold text-gray-700 mb-3">Folder Color</label>
                            <div class="bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border border-gray-200">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-6">
                                    <div class="flex items-center space-x-3">
                                        <input type="color" 
                                               name="color" 
                                               id="color" 
                                               value="{{ old('color', $folder->color) }}" 
                                               required
                                               class="w-16 h-12 border-2 border-gray-300 rounded-lg cursor-pointer shadow-sm hover:shadow-md transition-shadow duration-200">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-900">Selected Color</span>
                                            <span class="text-xs text-gray-500">Click to change</span>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-600">Choose a distinctive color to help identify and organize your folder visually</p>
                                    </div>
                                </div>
                            </div>
                            @error('color')
                                <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                    <i class='bx bx-error-circle'></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Enhanced Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-8 border-t border-gray-200">
                            <a href="{{ route('email.folders.index') }}" 
                               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium text-center">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-200 font-medium flex items-center justify-center gap-2">
                                <i class='bx bx-check text-lg'></i>
                                <span>Update Folder</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 