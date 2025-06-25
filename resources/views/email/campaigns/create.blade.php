<x-app-layout>
    <div class="container mx-auto px-3 pb-32 overflow-y-auto h-screen">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Create Video Email Campaign</h1>
                <a href="{{ route('email.campaigns.index') }}" 
                   class="text-gray-600 hover:text-gray-900">
                    ← Back to Campaigns
                </a>
            </div>

            <form action="{{ route('email.campaigns.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Basic Information -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Campaign Details</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Campaign Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('title')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Email Subject</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('subject')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Video Selection -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Video Selection</h2>
                    
                    <livewire:email-video-selector />
                    
                    @error('video_url')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    @error('thumbnail_url')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Content -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Email Content</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="body" class="block text-sm font-medium text-gray-700 mb-2">Message Body</label>
                            <textarea name="body" id="body" rows="6" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('body') }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Your personalized message to recipients</p>
                            @error('body')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="cta_text" class="block text-sm font-medium text-gray-700 mb-2">CTA Button Text</label>
                                <input type="text" name="cta_text" id="cta_text" value="{{ old('cta_text') }}"
                                       placeholder="Watch Video" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label for="cta_url" class="block text-sm font-medium text-gray-700 mb-2">CTA Button URL</label>
                                <input type="url" name="cta_url" id="cta_url" value="{{ old('cta_url') }}"
                                       placeholder="https://your-landing-page.com" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recipients -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Recipients</h2>
                    
                    <div>
                        <label for="recipients" class="block text-sm font-medium text-gray-700 mb-2">Email Addresses</label>
                        <textarea name="recipients" id="recipients" rows="4" required
                                  placeholder="email1@example.com, email2@example.com, email3@example.com"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('recipients') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Enter email addresses separated by commas</p>
                        @error('recipients')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Scheduling -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Scheduling</h2>
                    
                    <div>
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-2">Schedule Send (Optional)</label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Leave empty to save as draft</p>
                        @error('scheduled_at')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('email.campaigns.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Create Campaign
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cloudinary Script -->
    <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action="{{ route("email.campaigns.store") }}"]');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Clear the cached video data when form is submitted
                    const clearCacheEvent = new CustomEvent('clear-video-cache');
                    window.dispatchEvent(clearCacheEvent);
                });
            }
        });
    </script>
</x-app-layout> 