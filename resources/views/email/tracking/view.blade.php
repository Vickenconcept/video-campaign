<x-guest-layout>
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-50 to-purple-100 py-12 px-4">
    <div class="bg-white rounded-2xl shadow-xl p-0 max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 gap-0 overflow-hidden">
        <!-- Video Panel -->
        <div class="flex flex-col items-center justify-center p-8 border-b md:border-b-0 md:border-r border-gray-200 bg-white">
            <h1 class="text-2xl font-bold mb-2 text-indigo-700 text-center">You've received a personalized video!</h1>
            <p class="text-gray-600 mb-6 text-center">Thank you for viewing the video. Your view has been tracked.</p>
            @if(isset($recipient) && $recipient && $recipient->campaign && $recipient->campaign->video_url)
                <video controls poster="{{ $recipient->campaign->thumbnail_url ?: 'https://placehold.co/600x400' }}" class="rounded-lg shadow-lg max-w-full w-full object-cover mx-auto">
                    <source src="{{ $recipient->campaign->video_url }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="text-gray-700 text-base mt-4">
                    <span>Campaign: <strong>{{ $recipient->campaign->title }}</strong></span>
                </div>
            @else
                <div class="text-red-600 font-semibold mb-6">Video not available.</div>
            @endif
        </div>
        <!-- Chat/Reply Panel -->
        <div class="flex flex-col h-full p-6 bg-gray-50">
            @if(session('reply_success'))
                <div class="w-full mb-4 text-green-600 font-semibold text-center">{{ session('reply_success') }}</div>
            @endif
            <h2 class="text-lg font-semibold text-gray-800 mb-2 flex items-center justify-center">
                <i class='bx bx-message-dots text-indigo-500 text-2xl mr-2'></i> Conversation
            </h2>
            <div class="flex-1 flex flex-col">
                <div class="bg-white border border-gray-200 rounded-lg p-4 max-h-80 min-h-[120px] overflow-y-auto flex flex-col gap-3 mb-4">
                    @if($replies && $replies->count())
                        @foreach($replies as $reply)
                            @php
                                $isAdmin = isset($recipient->campaign->user) && $reply->sender_email === $recipient->campaign->user->email;
                            @endphp
                            <div class="flex {{ $isAdmin ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[80%] px-4 py-2 rounded-2xl shadow {{ $isAdmin ? 'bg-indigo-100 text-indigo-900' : 'bg-gray-50 text-gray-800 border' }}">
                                    <div class="text-sm whitespace-pre-line">{{ $reply->message }}</div>
                                    <div class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                        <span>{{ $reply->sender_name ?: ($isAdmin ? 'Admin' : 'Anonymous') }}</span>
                                        @if($reply->sender_email)
                                            <span>({{ $reply->sender_email }})</span>
                                        @endif
                                        <span>· {{ $reply->created_at->format('M j, Y g:i A') }}</span>
                                    </div>
                                    @if($isOwner && !$isAdmin)
                                        <form method="POST" action="{{ route('email.tracking.reply') }}" class="mt-2 flex flex-col md:flex-row md:items-center gap-2">
                                            @csrf
                                            <input type="hidden" name="email_recipient_id" value="{{ $recipient->uuid }}">
                                            <input type="hidden" name="sender_name" value="{{ $recipient->campaign->user->name }}">
                                            <input type="hidden" name="sender_email" value="{{ $recipient->campaign->user->email }}">
                                            <input type="text" name="message" placeholder="Reply to this user..." class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md">Reply</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-gray-500 text-center mb-4">No replies yet. Be the first to reply!</div>
                    @endif
                </div>
                <div class="w-full mt-auto">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2 flex items-center justify-center">
                        <i class='bx bx-message-dots text-indigo-500 text-2xl mr-2'></i> Reply to this video
                    </h2>
                    <form method="POST" action="{{ route('email.tracking.reply') }}" class="space-y-3" id="reply-form">
                        @csrf
                        <input type="hidden" name="email_recipient_id" value="{{ $recipient->uuid }}">
                        <div class="flex flex-col md:flex-row gap-2">
                            <input type="text" name="sender_name" placeholder="Your name (optional)" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            <input type="email" name="sender_email" placeholder="Your email (optional)" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        </div>
                        <textarea name="message" id="reply" rows="3" required placeholder="Write your reply here..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none"></textarea>
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition-colors">Send Reply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>