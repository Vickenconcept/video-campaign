<x-app-layout>
    <div class="container mx-auto px-3 pb-32 overflow-y-auto h-screen">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Edit Video Email Campaign</h1>
                <a href="{{ route('email.campaigns.index') }}" class="text-gray-600 hover:text-gray-900">← Back to Campaigns</a>
            </div>
            <form action="{{ route('email.campaigns.update', $campaign) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Campaign Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Campaign Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $campaign->title) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('title')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Email Subject</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject', $campaign->subject) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('subject')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="email_folder_id" class="block text-sm font-medium text-gray-700 mb-2">Folder (Optional)</label>
                        <select name="email_folder_id" id="email_folder_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">No Folder</option>
                            @php
                                $folders = \App\Models\EmailFolder::where('user_id', auth()->id())->orderBy('name')->get();
                            @endphp
                            @foreach($folders as $folder)
                                <option value="{{ $folder->id }}" {{ old('email_folder_id', $campaign->email_folder_id) == $folder->id ? 'selected' : '' }}>
                                    {{ $folder->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Organize your campaigns by grouping them in folders</p>
                        @error('email_folder_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Video Selection</h2>
                    
                    <livewire:email-video-selector-edit :video-url="$campaign->video_url" :thumbnail-url="$campaign->thumbnail_url" />
                    
                    @error('video_url')<p class="text-red-600 text-sm mt-2">{{ $message }}</p>@enderror
                    @error('thumbnail_url')<p class="text-red-600 text-sm mt-2">{{ $message }}</p>@enderror
                </div>
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Email Content</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="body" class="block text-sm font-medium text-gray-700 mb-2">Message Body</label>
                            <textarea name="body" id="body" rows="6" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('body', $campaign->body) }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Your personalized message to recipients</p>
                            @error('body')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="cta_text" class="block text-sm font-medium text-gray-700 mb-2">CTA Button Text</label>
                                <input type="text" name="cta_text" id="cta_text" value="{{ old('cta_text', $campaign->cta_text) }}" placeholder="Watch Video" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="cta_url" class="block text-sm font-medium text-gray-700 mb-2">CTA Button URL</label>
                                <input type="url" name="cta_url" id="cta_url" value="{{ old('cta_url', $campaign->cta_url) }}" placeholder="https://your-landing-page.com" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6" x-data="{
                    activeTab: 'direct',
                    videoEmails: [],
                    excelEmails: [],
                    selectedCampaigns: [],
                    isLoadingVideo: false,
                    isLoadingExcel: false,
                    recipientsValue: '{{ old('recipients', $recipients) }}',
                    toggleCampaign(campaignId) {
                        const index = this.selectedCampaigns.indexOf(campaignId);
                        if (index > -1) {
                            this.selectedCampaigns.splice(index, 1);
                        } else {
                            this.selectedCampaigns.push(campaignId);
                        }
                    },
                    async importFromVideoCampaigns() {
                        if (this.selectedCampaigns.length === 0) {
                            alert('Please select at least one campaign');
                            return;
                        }
                        this.isLoadingVideo = true;
                        try {
                            const response = await fetch('{{ route('email.campaigns.import.video') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    campaign_ids: this.selectedCampaigns
                                })
                            });
                            const data = await response.json();
                            if (data.success) {
                                this.videoEmails = data.emails;
                                this.recipientsValue = data.emails.join(', ');
                                this.activeTab = 'direct';
                                this.updateTextarea();
                                alert(`Successfully imported ${data.count} emails!`);
                            } else {
                                alert('Error importing emails: ' + data.message);
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Error importing emails from video campaigns');
                        } finally {
                            this.isLoadingVideo = false;
                        }
                    },
                    async handleFileUpload(event) {
                        const file = event.target.files[0];
                        if (!file) return;
                        const allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/csv'];
                        if (!allowedTypes.includes(file.type)) {
                            alert('Please select a valid Excel or CSV file');
                            return;
                        }
                        if (file.size > 2 * 1024 * 1024) {
                            alert('File size must be less than 2MB');
                            return;
                        }
                        this.isLoadingExcel = true;
                        const formData = new FormData();
                        formData.append('excel_file', file);
                        try {
                            const response = await fetch('{{ route('email.campaigns.import.excel') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                                },
                                body: formData
                            });
                            const data = await response.json();
                            if (data.success) {
                                this.excelEmails = data.emails;
                                this.recipientsValue = data.emails.join(', ');
                                this.activeTab = 'direct';
                                this.updateTextarea();
                                alert(`Successfully imported ${data.count} emails from Excel file!`);
                            } else {
                                alert('Error importing file: ' + data.message);
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Error importing Excel file');
                        } finally {
                            this.isLoadingExcel = false;
                        }
                    },
                    updateTextarea() {
                        this.$nextTick(() => {
                            document.getElementById('recipients').value = this.recipientsValue;
                        });
                    }
                }" x-init="updateTextarea()">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Recipients</h2>
                    <!-- Toggle Buttons -->
                    <div class="flex justify-center mb-6">
                        <div class="flex bg-gray-100 rounded-lg p-1">
                            <button type="button"
                                    @click="activeTab = 'direct'; updateTextarea()"
                                    :class="{ 'bg-white shadow-sm': activeTab === 'direct', 'text-gray-500': activeTab !== 'direct' }"
                                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Direct Input
                            </button>
                            <button type="button"
                                    @click="activeTab = 'video'; updateTextarea()"
                                    :class="{ 'bg-white shadow-sm': activeTab === 'video', 'text-gray-500': activeTab !== 'video' }"
                                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Import from Video Campaigns
                            </button>
                            <button type="button"
                                    @click="activeTab = 'excel'; updateTextarea()"
                                    :class="{ 'bg-white shadow-sm': activeTab === 'excel', 'text-gray-500': activeTab !== 'excel' }"
                                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Import from Excel
                            </button>
                        </div>
                    </div>
                    <!-- Recipients Textarea (always present, value managed by Alpine) -->
                    <div>
                        <label for="recipients" class="block text-sm font-medium text-gray-700 mb-2">Email Addresses</label>
                        <textarea name="recipients" id="recipients" rows="4" required
                                  placeholder="email1@example.com, email2@example.com, email3@example.com"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  x-model="recipientsValue"
                                  :readonly="activeTab !== 'direct'"
                        ></textarea>
                        <p class="text-sm text-gray-500 mt-1">Enter email addresses separated by commas</p>
                        @error('recipients')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Import UI for video/excel tabs -->
                    <div x-show="activeTab === 'video'" class="mt-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Video Campaigns</label>
                                <div class="max-h-48 overflow-y-auto border border-gray-300 rounded-md p-3">
                                    @php
                                        $campaigns = \App\Models\Campaign::whereHas('folder', function($query) {
                                            $query->where('user_id', auth()->id());
                                        })->get();
                                    @endphp
                                    @forelse($campaigns as $campaign)
                                        <label class="flex items-center space-x-2 py-1">
                                            <input type="checkbox"
                                                   value="{{ $campaign->id }}"
                                                   @change="toggleCampaign({{ $campaign->id }})"
                                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm text-gray-700">{{ $campaign->title }}</span>
                                        </label>
                                    @empty
                                        <p class="text-sm text-gray-500">No video campaigns found</p>
                                    @endforelse
                                </div>
                            </div>
                            <button type="button"
                                    @click="importFromVideoCampaigns()"
                                    :disabled="selectedCampaigns.length === 0 || isLoadingVideo"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed flex items-center space-x-2">
                                <svg x-show="isLoadingVideo" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="isLoadingVideo ? 'Importing...' : 'Import Emails'"></span>
                            </button>
                        </div>
                    </div>
                    <div x-show="activeTab === 'excel'" class="mt-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Excel/CSV File</label>
                                <div class="relative">
                                    <input type="file"
                                           accept=".xlsx,.xls,.csv"
                                           :disabled="isLoadingExcel"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                           @change="handleFileUpload($event)">
                                    <div x-show="isLoadingExcel" class="absolute inset-0 bg-gray-100 bg-opacity-75 flex items-center justify-center rounded-md">
                                        <div class="flex items-center space-x-2 text-gray-600">
                                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span class="text-sm">Processing file...</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Supported formats: .xlsx, .xls, .csv (Max 2MB)</p>
                            </div>
                            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                <h4 class="text-sm font-medium text-blue-800 mb-2">Excel Format Requirements:</h4>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    <li>• File should have headers in the first row</li>
                                    <li>• Email column should be named: "email", "Email", "EMAIL", "e-mail", "E-mail", or "E-Mail"</li>
                                    <li>• Alternatively, any column containing valid email addresses will be detected</li>
                                    <li>• Duplicate emails will be automatically removed</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Scheduling</h2>
                    <div>
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-2">Schedule Send (Optional)</label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at', $campaign->scheduled_at ? $campaign->scheduled_at->format('Y-m-d\TH:i') : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Leave empty to save as draft</p>
                        <p class="text-sm text-amber-600 mt-1">⚠️ Note: All times are in UTC timezone</p>
                        @error('scheduled_at')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Template Customization</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="footer_line1" class="block text-sm font-medium text-gray-700 mb-2">Footer Line 1</label>
                            <input type="text" name="template_data[footer_line1]" id="footer_line1" value="{{ old('template_data.footer_line1', $campaign->template_data['footer_line1'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="footer_line2" class="block text-sm font-medium text-gray-700 mb-2">Footer Line 2</label>
                            <input type="text" name="template_data[footer_line2]" id="footer_line2" value="{{ old('template_data.footer_line2', $campaign->template_data['footer_line2'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <!-- Add more fields for other templates as needed -->
                    </div>
                </div>
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('email.campaigns.index') }}" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update Campaign</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cloudinary Script -->
    <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>
</x-app-layout> 