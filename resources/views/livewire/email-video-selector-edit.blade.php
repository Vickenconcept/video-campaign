<div class="space-y-6" x-data="{ 
    upload_type: 'upload',
    tab: 'avatar',
    selectedAvatar: null,
    selectedVoice: null,
    isGenerating: false,
    checkInterval: null,

    init() {
        Livewire.on('videoGenerationStarted', () => {
            this.isGenerating = true;
            this.checkInterval = setInterval(() => {
                @this.checkVideoStatus();
            }, 5000);
        });

        Livewire.on('video-generation-complete', ({ videoUrl, thumbnailUrl }) => {
            this.isGenerating = false;
            this.tab = 'video';
            if (this.checkInterval) {
                clearInterval(this.checkInterval);
            }
            document.getElementById('video_url').value = videoUrl;
            document.getElementById('thumbnail_url').value = thumbnailUrl;
        });

        window.addEventListener('cloudinary-upload-success', (event) => {
            const { videoUrl, thumbnailUrl } = event.detail;
            @this.setVideoUrl(videoUrl);
            @this.setThumbnailUrl(thumbnailUrl);
            document.getElementById('video_url').value = videoUrl;
            document.getElementById('thumbnail_url').value = thumbnailUrl;
        });

        // Handle video cache cleared event
        Livewire.on('video-cache-cleared', () => {
            this.tab = 'avatar';
            this.selectedAvatar = null;
            this.selectedVoice = null;
            this.isGenerating = false;
            if (this.checkInterval) {
                clearInterval(this.checkInterval);
            }
        });
    }
}">

    <!-- Current Video Display -->
    @if($videoUrl)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h4 class="font-medium text-blue-900 mb-2">Current Video</h4>
            <video controls class="w-full max-w-md mx-auto rounded-lg">
                <source src="{{ $videoUrl }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="mt-2 text-sm text-blue-700">
                <p><strong>Video URL:</strong> {{ $videoUrl }}</p>
                <p><strong>Thumbnail URL:</strong> {{ $thumbnailUrl }}</p>
            </div>
        </div>
    @endif

    <!-- Upload Type Toggle -->
    <div class="flex justify-center mb-6">
        <div class="flex bg-gray-100 rounded-lg p-1">
            <button type="button" 
                    @click="upload_type = 'upload'; $wire.uploadType = 'upload'"
                    :class="{ 'bg-white shadow-sm': upload_type === 'upload', 'text-gray-500': upload_type !== 'upload' }"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors">
                Upload New Video
            </button>
            <button type="button" 
                    @click="upload_type = 'avatar_video'; $wire.uploadType = 'avatar_video'"
                    :class="{ 'bg-white shadow-sm': upload_type === 'avatar_video', 'text-gray-500': upload_type !== 'avatar_video' }"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors">
                Generate AI Avatar Video
            </button>
        </div>
    </div>

    <!-- Cloudinary Upload Section -->
    <div x-show="upload_type === 'upload'" class="space-y-4">
        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
            <div class="mb-4">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <button type="button" id="upload_widget_edit" class="cloudinary-button bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                Upload New Video
            </button>
            <p class="text-sm text-gray-500 mt-2">Click to upload a new video (max 100MB)</p>
        </div>

        <!-- New Uploaded Video Preview -->
        <div x-show="$wire.videoUrl && $wire.videoUrl !== '{{ $videoUrl }}'" class="bg-white border rounded-lg p-4">
            <h4 class="font-medium text-gray-900 mb-2">New Uploaded Video</h4>
            <video controls class="w-full max-w-md mx-auto rounded-lg">
                <template x-if="$wire.videoUrl.endsWith('.mp4')">
                    <source :src="$wire.videoUrl" type="video/mp4">
                </template>
                <template x-if="$wire.videoUrl.endsWith('.webm')">
                    <source :src="$wire.videoUrl" type="video/webm">
                </template>
                <template x-if="$wire.videoUrl.endsWith('.mov')">
                    <source :src="$wire.videoUrl" type="video/quicktime">
                </template>
                <p>Your browser does not support the video tag.</p>
            </video>
            <div class="mt-2 text-sm text-gray-600">
                <p><strong>Video URL:</strong> <span x-text="$wire.videoUrl"></span></p>
                <p><strong>Thumbnail URL:</strong> <span x-text="$wire.thumbnailUrl"></span></p>
            </div>
        </div>
    </div>

    <!-- AI Avatar Video Section -->
    <div x-show="upload_type === 'avatar_video'" style="display: none;" class="space-y-6">
        <!-- Loading Overlay -->
        <div x-show="isGenerating" 
             class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 h-screen">
            <div class="bg-white rounded-lg p-8 text-center">
                <div class="mb-4">
                    <i class='bx bx-loader animate-spin text-4xl text-blue-600'></i>
                </div>
                <p class="font-medium text-gray-900">Generating AI Video...</p>
                <p class="text-sm text-gray-600 mt-2">This may take a few minutes</p>
            </div>
        </div>

        <!-- Error Messages -->
        @error('video')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <span class="block sm:inline">{{ $message }}</span>
            </div>
        @enderror

        <!-- Avatar Selection -->
        <div x-show="tab === 'avatar'" class="space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Select Avatar</h3>
                <button type="button" 
                        @click="tab = 'voice'" 
                        :disabled="selectedAvatar === null"
                        :class="{ 'bg-blue-600': selectedAvatar !== null, 'bg-gray-400 cursor-not-allowed': selectedAvatar === null }"
                        class="text-white px-4 py-2 rounded-md text-sm">
                    Next
                </button>
            </div>
            
            <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <template x-for="(avatar, index) in $wire.avatars" :key="avatar.id">
                    <div x-show="index > 0"
                         class="cursor-pointer p-2 rounded-lg transition-all duration-200 border border-gray-300 bg-white hover:shadow-md"
                         :class="{ 'ring-2 ring-blue-500 bg-blue-50': selectedAvatar === avatar.id }"
                         @click="selectedAvatar = avatar.id; $wire.selectAvatar(avatar.id)">
                        <img :src="avatar.image_url ? avatar.image_url : 'https://placehold.co/80x80'"
                             :alt="avatar.name" 
                             class="w-full h-auto rounded-lg">
                        <p class="text-xs text-center mt-1" x-text="avatar.name"></p>
                    </div>
                </template>
            </div>
        </div>

        <!-- Voice Selection -->
        <div x-show="tab === 'voice'" class="space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Select Voice</h3>
                <div class="flex space-x-2">
                    <button type="button" 
                            @click="tab = 'avatar'; selectedAvatar = null; $wire.selectAvatar(null)"
                            class="bg-gray-600 text-white px-4 py-2 rounded-md text-sm">
                        Back
                    </button>
                    <button type="button" 
                            @click="tab = 'script'" 
                            :disabled="selectedVoice === null"
                            :class="{ 'bg-blue-600': selectedVoice !== null, 'bg-gray-400 cursor-not-allowed': selectedVoice === null }"
                            class="text-white px-4 py-2 rounded-md text-sm">
                        Next
                    </button>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="voice in $wire.voices" :key="voice.id">
                    <div class="cursor-pointer p-4 border rounded-lg transition-all duration-200 bg-gray-50 hover:shadow-md"
                         :class="{ 'ring-2 ring-blue-500 bg-blue-50': selectedVoice === voice.id }"
                         @click="selectedVoice = voice.id; $wire.selectVoice(voice.id)">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-sm" x-text="voice.name"></p>
                                <p class="text-sm text-gray-500" x-text="voice.language"></p>
                                <p class="text-xs text-gray-700" x-text="voice.gender"></p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="button"
                                    class="w-full px-3 py-1 text-sm text-blue-600 border border-blue-600 rounded-md hover:bg-blue-50"
                                    @click.stop="$wire.previewVoice(voice.id)">
                                Preview Voice
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Script Input -->
        <div x-show="tab === 'script'" class="space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Write Script</h3>
                <div class="flex space-x-2">
                    <button type="button" 
                            @click="tab = 'voice'; selectedVoice = null; $wire.selectVoice(null)"
                            class="bg-gray-600 text-white px-4 py-2 rounded-md text-sm">
                        Back
                    </button>
                    <button type="button"
                            wire:click="generateVideo"
                            :disabled="!$wire.content?.trim()"
                            :class="{ 'bg-blue-600': $wire.content?.trim(), 'bg-gray-400 cursor-not-allowed': !$wire.content?.trim() }"
                            class="text-white px-4 py-2 rounded-md text-sm">
                        <span wire:loading.remove wire:target="generateVideo">Generate Video</span>
                        <span wire:loading wire:target="generateVideo">Generating...</span>
                    </button>
                </div>
            </div>
            
            <textarea wire:model.live="content" 
                      rows="6"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      placeholder="Enter the script for your AI avatar video..."></textarea>
        </div>

        <!-- Generated Video Preview -->
        <div x-show="tab === 'video' && $wire.videoUrl" class="space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Generated Video</h3>
                <div class="flex space-x-2">
                    <button type="button" 
                            @click="tab = 'script'"
                            class="bg-gray-600 text-white px-4 py-2 rounded-md text-sm">
                        Back
                    </button>
                    <button type="button"
                            wire:click="clearCachedVideo"
                            class="bg-red-600 text-white px-4 py-2 rounded-md text-sm hover:bg-red-700 transition-colors">
                        Clear Cache
                    </button>
                </div>
            </div>
            
            <div class="bg-white border rounded-lg p-4">
                {{-- <video controls class="w-full max-w-md mx-auto rounded-lg">
                    <source :src="$wire.videoUrl" type="video/mp4">
                    Your browser does not support the video tag.
                </video> --}}

                <video controls class="w-full max-w-md mx-auto rounded-lg">
                    <template x-if="$wire.videoUrl.endsWith('.mp4')">
                        <source :src="$wire.videoUrl" type="video/mp4">
                    </template>
                    <template x-if="$wire.videoUrl.endsWith('.webm')">
                        <source :src="$wire.videoUrl" type="video/webm">
                    </template>
                    <template x-if="$wire.videoUrl.endsWith('.mov')">
                        <source :src="$wire.videoUrl" type="video/quicktime">
                    </template>
                    <p>Your browser does not support the video tag.</p>
                </video>
                <div class="mt-2 text-sm text-gray-600">
                    <p><strong>Video URL:</strong> <span x-text="$wire.videoUrl"></span></p>
                    <p><strong>Thumbnail URL:</strong> <span x-text="$wire.thumbnailUrl"></span></p>
                </div>
                <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                    <p class="text-sm text-blue-800">
                        <i class='bx bx-info-circle mr-1'></i>
                        This video is cached for 5 minutes. You can clear the cache to start fresh.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Form Fields -->
    <input type="hidden" id="video_url" name="video_url" value="{{ $videoUrl }}">
    <input type="hidden" id="thumbnail_url" name="thumbnail_url" value="{{ $thumbnailUrl }}">

</div>




<script src="https://upload-widget.cloudinary.com/latest/global/all.js" type="text/javascript"></script>
<script>
    let myWidget; // Declare outside so it's accessible

    function initializeCloudinaryWidget() {
        const uploadButton = document.getElementById('upload_widget_edit');
        if (typeof cloudinary !== 'undefined' && uploadButton) {
            try {
                // Initialize widget only once
                if (!myWidget) {
                    myWidget = cloudinary.createUploadWidget({
                        uploadPreset: "video-campaign",
                        cloudName: '{{ env('CLOUDINARY_CLOUD_NAME') }}',
                        resourceType: 'video',
                        maxFiles: 1,
                        multiple: false,
                        clientAllowedFormats: ["mp4", "avi", "mov", "webm", "mkv", "wmv", "flv"],
                        maxFileSize: 500000000
                    }, function(error, result) {
                        if (!error && result && result.event === "success") {
                            const videoUrl = result.info.secure_url;
                            const thumbnailUrl = result.info.thumbnail_url || videoUrl;

                            window.dispatchEvent(new CustomEvent('cloudinary-upload-success', {
                                detail: {
                                    videoUrl,
                                    thumbnailUrl
                                }
                            }));

                            Toastify({
                                text: `Uploaded! Successfully`,
                                position: "center",
                                duration: 3000,
                                backgroundColor: "linear-gradient(to right, #56ab2f, #a8e063)"
                            }).showToast();

                            // Properly close the widget
                            myWidget.close();

                            // Optional: disable the button if needed
                            uploadButton.removeEventListener("click", openWidget);
                        }
                    });
                }

                // Attach the click handler
                uploadButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    myWidget.open();
                });

            } catch (error) {
                console.error('Error initializing Cloudinary widget:', error);
            }
        }
    }

    // DOM ready
    document.addEventListener('DOMContentLoaded', initializeCloudinaryWidget);

    // When Livewire navigates
    document.addEventListener('livewire:navigated', () => {
        setTimeout(initializeCloudinaryWidget, 100);
    });

    // Fallback
    setTimeout(initializeCloudinaryWidget, 1000);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.addEventListener('play-audio', event => {
            console.log("Full event object:", event.detail);
            const audioData = Array.isArray(event.detail) ? event.detail[0] : event.detail;
            if (!audioData?.url) {
                console.error("Audio URL is missing!");
                return;
            }

            if (window.currentAudio) {
                window.currentAudio.pause();
                window.currentAudio.currentTime = 0;
            }
            const audio = new Audio(audioData.url);
            window.currentAudio = audio;
            audio.play().catch(error => console.error("Audio playback error:", error));
        });

    })
</script>