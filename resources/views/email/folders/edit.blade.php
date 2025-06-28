<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center mb-8">
                <a href="{{ route('email.folders.index') }}" 
                   class="text-gray-600 hover:text-gray-900 mr-4">
                    ← Back to Folders
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Edit Folder</h1>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('email.folders.update', $folder) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Folder Name</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $folder->name) }}" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $folder->description) }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Folder Color</label>
                            <div class="flex items-center space-x-4">
                                <input type="color" 
                                       name="color" 
                                       id="color" 
                                       value="{{ old('color', $folder->color) }}" 
                                       required
                                       class="w-16 h-10 border border-gray-300 rounded-md cursor-pointer">
                                <span class="text-sm text-gray-500">Choose a color to identify this folder</span>
                            </div>
                            @error('color')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-4 pt-6">
                            <a href="{{ route('email.folders.index') }}" 
                               class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Update Folder
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 