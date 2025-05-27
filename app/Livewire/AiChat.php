<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ChatGptService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class AiChat extends Component
{
    public $message = '';
    public $messages = [];
    public $isLoading = false;
    public $auth_id;
    public $preview;

    protected $listeners = ['scrollToBottom'];

    public function mount($preview = null)
    {
        // session()->flush();
        $this->preview = $preview;

        if (auth()->check()) {
            $this->auth_id = auth()->id();
        } else {
            $cacheKey = 'guest_chat_id';
            $this->auth_id = Cache::remember($cacheKey, now()->addHours(24), function () {
                return 'guest_' . Str::random(16);
            });
        }

        $this->messages = session("chat_messages_{$this->auth_id}", []);
    }


    public function sendMessage()
    {
        if (empty(trim($this->message))) {
            return;
        }

        $this->messages[] = [
            'role' => 'user',
            'content' => $this->message,
            'timestamp' => now()->format('g:i A')
        ];

        session(["chat_messages_{$this->auth_id}" => $this->messages]);

        $userMessage = $this->message;
        $this->message = '';
        $this->isLoading = true;

        $this->dispatch('scrollToBottom');

        $this->dispatch('handleAiResponse', $userMessage);
    }

    // #[On('handleAiResponse')]
    // public function handleAiResponse($userMessage)
    // {
    //     try {
    //         $chatGptService = app(ChatGptService::class);
    //         $response = $chatGptService->generateContent($userMessage);

    //         $this->messages[] = [
    //             'role' => 'assistant',
    //             'content' => $response,
    //             'timestamp' => now()->format('g:i A')
    //         ];
    //     } catch (\Exception $e) {
    //         $this->messages[] = [
    //             'role' => 'assistant',
    //             'content' => 'Sorry, there was an error processing your request. Please try again.',
    //             'timestamp' => now()->format('g:i A')
    //         ];
    //     } finally {
    //         $this->isLoading = false;
    //         session(["chat_messages_{$this->auth_id}" => $this->messages]);
    //         $this->dispatch('scrollToBottom');
    //     }
    // }

    #[On('handleAiResponse')]
    public function handleAiResponse($userMessage)
    {
        try {
            $chatGptService = app(ChatGptService::class);
            $response = $chatGptService->generateContent($userMessage);

            $response = is_string($response) ? $response : 'Sorry, I could not generate a response.';

            $this->messages[] = [
                'role' => 'assistant',
                'content' => $response,
                'timestamp' => now()->format('g:i A')
            ];
        } catch (\Exception $e) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => 'Sorry, there was an error processing your request. Please try again.',
                'timestamp' => now()->format('g:i A')
            ];
        } finally {
            $this->isLoading = false;
            session(["chat_messages_{$this->auth_id}" => $this->messages]);
            $this->dispatch('scrollToBottom');
        }
    }



    public function clearChat()
    {
        $this->messages = [];
        session(["chat_messages_{$this->auth_id}" => []]);
    }

    public function render()
    {
        return view('livewire.ai-chat');
    }
}
