<?php

namespace App\Livewire;

use App\Services\PipioService;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class VideoSetup extends Component
{


    public $activeStep;

    public $avatars = [];
    public $voices = [];
    public $selectedVoice = null;
    public $selectedAvatar = null;
    public $content = '';
    public $videoUrl = null;

    protected $pipioService;
    protected $cacheDuration = 86400;

    public function mount($activeStep)
    {
        $this->activeStep = $activeStep;

        $this->videoUrl =  $this->activeStep->video_url ?? '';
        $this->content = strip_tags('hello this is the content');
        $this->pipioService = app(PipioService::class);

        $this->loadAvatarsAndVoices();
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
    }

    public function selectAvatar($avatarId)
    {
        $this->selectedAvatar = $avatarId;
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
            $this->addError('video', 'Please select both an avatar and voice before generating the video');
            return;
        }

        $this->pipioService = app(PipioService::class);

        try {

            $response = $this->pipioService->generateVideo(
                $this->selectedAvatar,
                $this->selectedVoice,
                $this->content
            );

            // if ($response) {
            $this->activeStep->update([
                'pipio_video_id' => $response['id'],
                'pipio_status' => 'processing'
            ]);

            $this->dispatch('videoGenerationStarted-'. $this->activeStep->id);
            // }
        } catch (\Exception $e) {
            $this->addError('video', 'Failed to generate video: ' . $e->getMessage());
        }
    }

    public function checkVideoStatus()
    {
        if (!$this->activeStep->pipio_video_id) {
            return;
        }

        $this->pipioService = app(PipioService::class);
        try {
            $status = $this->pipioService->checkVideoStatus($this->activeStep->pipio_video_id);

            if ($status && isset($status['status'])) {
                $this->activeStep->update([
                    'pipio_status' => $status['status']
                ]);

                if ($status['status'] === 'Failure') {
                    $this->dispatch('video-generation-complete-' . $this->activeStep->id, [
                        'videoUrl' => ''
                    ]);
                    $this->addError('video', 'Video Generation Failed');
                    return;
                }

                if ($status['status'] === 'Completed' && isset($status['videoUrl'])) {
                    $this->activeStep->update([
                        'video_url' => $status['videoUrl'],
                        'is_pipio_processed' => true
                    ]);

                    $this->videoUrl = $status['videoUrl'];

                    if ($this->activeStep->video_url && !empty($this->activeStep->video_url)) {
                        $this->dispatch('video-generation-complete-' . $this->activeStep->id, [
                            'videoUrl' => $this->activeStep->video_url
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->addError('video', 'Failed to check video status: ' . $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.video-setup');
    }
}
