<?php

namespace App\Livewire;

use App\Services\PipioService;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Cloudinary\Cloudinary;

class EmailVideoSelectorEdit extends Component
{
    public $videoUrl = '';
    public $thumbnailUrl = '';
    public $uploadType = 'upload'; // 'upload' or 'avatar_video'

    // AI Avatar Video Generation
    public $avatars = [];
    public $voices = [];
    public $selectedVoice = null;
    public $selectedAvatar = null;
    public $content = '';
    public $isGenerating = false;
    public $pipioVideoId = null;
    public $pipioStatus = null;

    protected $pipioService;
    protected $cacheDuration = 120; // 5 minutes in seconds

    public function mount($videoUrl = '', $thumbnailUrl = '')
    {
        $this->videoUrl = $videoUrl;
        $this->thumbnailUrl = $thumbnailUrl;
        $this->pipioService = app(PipioService::class);
        $this->loadAvatarsAndVoices();
        $this->loadCachedVideo();
    }

    protected function loadAvatarsAndVoices()
    {
        $this->avatars = Cache::remember('pipio_avatars_raw', $this->cacheDuration, function () {
            $avatarResponse = $this->pipioService->getAvatars();
            if (!$avatarResponse) {
                return [];
            }

            return array_map(function ($avatar) {
                return [
                    'id' => $avatar['id'],
                    'name' => $avatar['name'],
                    'image_url' => $avatar['thumbnailImagePath'],
                    'gender' => $avatar['gender'],
                    'type' => $avatar['actorType']
                ];
            }, $avatarResponse['items']);
        });

        $this->voices = Cache::remember('pipio_voices_raw', $this->cacheDuration, function () {
            $voiceResponse = $this->pipioService->getVoices();
            if (!$voiceResponse) {
                return [];
            }

            return array_map(function ($voice) {
                return [
                    'id' => $voice['id'],
                    'name' => $voice['name'],
                    'language' => implode(', ', $voice['languages']),
                    'gender' => $voice['gender'],
                    'type' => $voice['voiceType'],
                    'preview_url' => $voice['previewAudioPath']
                ];
            }, $voiceResponse['items']);
        });
    }

    protected function loadCachedVideo()
    {
        $cachedVideo = Cache::get('pipio_generated_video_session_' . session()->getId());
        if ($cachedVideo) {
            $this->videoUrl = $cachedVideo['videoUrl'] ?? '';
            $this->thumbnailUrl = $cachedVideo['thumbnailUrl'] ?? '';
            $this->pipioVideoId = $cachedVideo['pipioVideoId'] ?? null;
            $this->pipioStatus = $cachedVideo['pipioStatus'] ?? null;
            $this->content = $cachedVideo['content'] ?? '';
            $this->selectedAvatar = $cachedVideo['selectedAvatar'] ?? null;
            $this->selectedVoice = $cachedVideo['selectedVoice'] ?? null;
        }
    }

    public function cacheGeneratedVideo()
    {
        $videoData = [
            'videoUrl' => $this->videoUrl,
            'thumbnailUrl' => $this->thumbnailUrl,
            'pipioVideoId' => $this->pipioVideoId,
            'pipioStatus' => $this->pipioStatus,
            'content' => $this->content,
            'selectedAvatar' => $this->selectedAvatar,
            'selectedVoice' => $this->selectedVoice,
            'generated_at' => now()->timestamp
        ];

        Cache::put('pipio_generated_video_session_' . session()->getId(), $videoData, $this->cacheDuration);
    }

    public function clearCachedVideo()
    {
        Cache::forget('pipio_generated_video_session_' . session()->getId());
        $this->videoUrl = '';
        $this->thumbnailUrl = '';
        $this->pipioVideoId = null;
        $this->pipioStatus = null;
        $this->content = '';
        $this->selectedAvatar = null;
        $this->selectedVoice = null;
        $this->isGenerating = false;

        $this->dispatch('video-cache-cleared');
    }

    public function refreshPipioData()
    {
        Cache::forget('pipio_avatars_raw');
        Cache::forget('pipio_voices_raw');
        $this->loadAvatarsAndVoices();
        $this->dispatch('pipioDataRefreshed');
    }

    public function selectVoice($voiceId)
    {
        $this->selectedVoice = $voiceId;
        $this->cacheGeneratedVideo();
    }

    public function selectAvatar($avatarId)
    {
        $this->selectedAvatar = $avatarId;
        $this->cacheGeneratedVideo();
    }

    public function previewVoice($voiceId)
    {
        $voice = collect($this->voices)->firstWhere('id', $voiceId);
        if ($voice && isset($voice['preview_url'])) {
            $this->dispatch('play-audio', ['url' => $voice['preview_url']]);
        }
    }

    public function generateVideo()
    {
        if (!$this->selectedAvatar || !$this->selectedVoice || !$this->content) {
            $this->addError('video', 'Please select both an avatar and voice, and add content before generating the video');
            return;
        }

        $this->pipioService = app(PipioService::class);
        try {
            $response = $this->pipioService->generateVideo(
                $this->selectedAvatar,
                $this->selectedVoice,
                $this->content
            );

            $this->pipioVideoId = $response['id'];
            $this->pipioStatus = 'processing';
            $this->isGenerating = true;

            $this->cacheGeneratedVideo();
            $this->dispatch('videoGenerationStarted');
        } catch (\Exception $e) {
            $this->addError('video', 'Failed to generate video: ' . $e->getMessage());
        }
    }

    public function checkVideoStatus()
    {
        if (!$this->pipioVideoId) {
            return;
        }

        $this->pipioService = app(PipioService::class);
        try {
            $status = $this->pipioService->checkVideoStatus($this->pipioVideoId);

            if ($status && isset($status['status'])) {
                $this->pipioStatus = $status['status'];

                if ($status['status'] === 'Failure') {
                    $this->isGenerating = false;
                    $this->addError('video', 'Video Generation Failed');
                    $this->cacheGeneratedVideo();
                    return;
                }

                if ($status['status'] === 'Completed' && isset($status['videoUrl'])) {
                    $this->videoUrl = $status['videoUrl'];
                    $this->thumbnailUrl = $status['videoUrl']; // Use video URL as thumbnail for now
                    $this->isGenerating = false;

                    $this->cacheGeneratedVideo();
                    $this->dispatch('video-generation-complete', [
                        'videoUrl' => $this->videoUrl,
                        'thumbnailUrl' => $this->thumbnailUrl
                    ]);
                }
            }
        } catch (\Exception $e) {
            $this->addError('video', 'Failed to check video status: ' . $e->getMessage());
        }
    }

    public function setVideoUrl($url)
    {
        $url = str_replace('/upload/', '/upload/f_mp4/', $url);

        if (str_contains($url, 'f_mp4')) {
            $url = preg_replace('/\.mkv$/i', '.mp4', $url);
        }

        $this->videoUrl = $url;

        $this->cacheGeneratedVideo();
        $this->dispatch('video-url-updated', ['url' => $url]);
    }



    public function setThumbnailUrl($url)
    {
        $this->thumbnailUrl = $url;
        $this->cacheGeneratedVideo();
        $this->dispatch('thumbnail-url-updated', ['url' => $url]);
    }

    public function render()
    {
        return view('livewire.email-video-selector-edit');
    }
}
