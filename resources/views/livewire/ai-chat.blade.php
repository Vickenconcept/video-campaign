<!-- resources/views/livewire/ai-chat.blade.php -->
<div class="flex flex-col h-[60vh] max-w-3xl mx-auto">
    <div class="flex flex-col h-full bg-white border rounded-lg shadow-lg overflow-hidden">
        <!-- Chat header -->
        <div class="bg-blue-600 p-4 text-white flex justify-between items-center  border-b">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <h2 class="text-lg font-medium">AI Assistant</h2>
            </div>
            <div>
                @if ($isLoading)
                    <div class="flex justify-start">
                        <div class="">
                            <div class="flex space-x-2">
                                <div class="h-2 w-2 bg-gray-100 rounded-full animate-bounce"
                                    style="animation-delay: 0ms">
                                </div>
                                <div class="h-2 w-2 bg-gray-100 rounded-full animate-bounce"
                                    style="animation-delay: 150ms">
                                </div>
                                <div class="h-2 w-2 bg-gray-100 rounded-full animate-bounce"
                                    style="animation-delay: 300ms">
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <button wire:click="clearChat" class="cursor-pointer">clear</button>
                @endif
            </div>
        </div>


        <div x-data="{
            initScroll() {
                this.$el.scrollTop = this.$el.scrollHeight - 200; // push 100px further 
            }
        }" x-init="initScroll()" @scroll-to-bottom.window="initScroll()"
            class="flex-1 overflow-y-auto p-4 space-y-4">
            {{-- <div x-data="{ initScroll() { this.$el.scrollTop = this.$el.scrollHeight; } }" x-init="initScroll()" @scroll-to-bottom.window="initScroll()"
            class="flex-1 overflow-y-auto p-4 space-y-4" id="chat-messages"> --}}
            @if (count($messages) === 0)
                <div class="flex items-center justify-center h-full text-gray-400 flex-col gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <p>Start a conversation with the AI assistant</p>
                </div>
            @else
                @foreach ($messages as $msg)
                    <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                        <div
                            class="max-w-[80%] rounded-lg px-4 py-2 
                            {{ $msg['role'] === 'user'
                                ? 'bg-blue-600 text-white rounded-br-none'
                                : 'bg-gray-100 text-gray-800 rounded-bl-none' }}">
                            {{-- <div class="break-words">{!! nl2br(e($msg['content'])) !!}</div> --}}
                            <div class="break-words">{!! nl2br(Str::markdown($msg['content'])) !!}</div>
                            
                            <div
                                class="text-xs mt-1 text-right 
                                {{ $msg['role'] === 'user' ? 'text-white/70' : 'text-gray-500' }}">
                                {{ $msg['timestamp'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif


            <!-- Loading indicator -->
            @if ($isLoading)
                <div class="flex justify-start">
                    <div class="bg-gray-100 p-3 rounded-lg rounded-bl-none">
                        <div class="flex space-x-2">
                            <div class="h-2 w-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms">
                            </div>
                            <div class="h-2 w-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms">
                            </div>
                            <div class="h-2 w-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Input area -->
        <div class="p-4 border-t">
            <form wire:submit.prevent="sendMessage" class="flex items-center gap-2">
                <input wire:model.live="message" wire:keydown.enter="sendMessage" placeholder="Type your message..."
                    class="flex-1 border rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    {{ $isLoading ? 'disabled' : '' }} {{ $preview ? 'readonly' : '' }} autocomplete="off">
                <button type="submit"
                    class="p-2 rounded-full bg-blue-600 text-white disabled:opacity-50 cursor-pointer"
                    {{ $isLoading || !trim($message) ? 'disabled' : '' }}>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                    <span class="sr-only">Send</span>
                </button>
            </form>
        </div>
    </div>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('scrollToBottom', () => {
                const container = document.getElementById('chat-messages');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        });
    </script> --}}


</div>
