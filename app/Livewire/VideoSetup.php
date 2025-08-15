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
    public $uploadType = 'upload'; // 'upload', 'avatar_video', or 'external_url'
    public $externalVideoUrl = ''; // For YouTube/Vimeo URLs

    protected $pipioService;
    protected $cacheDuration = 86400;

    protected $rules = [
        'externalVideoUrl' => 'required|url'
    ];

    protected function validateExternalVideoUrl($attribute, $value, $fail)
    {
        if (!empty($value)) {
            if (!str_contains($value, 'youtube.com') && 
                !str_contains($value, 'youtu.be') && 
                !str_contains($value, 'vimeo.com')) {
                $fail('Please enter a valid YouTube or Vimeo URL.');
            }
        }
    }

    public $fit_video, $video_setting, $position_video, $overlay_text = '', $text_size, $overlay_bg;

    public function mount($activeStep)
    {
        $this->activeStep = $activeStep;

        $this->video_setting = json_decode($this->activeStep->video_setting, true) ?? [];
        $this->fit_video = $this->video_setting['fit'] ?? null;
        $this->position_video = $this->video_setting['position'] ?? null;
        $this->overlay_text = $this->video_setting['overlay_text'] ?? null;
        $this->text_size = $this->video_setting['text_size'] ?? null;
        $this->overlay_bg = $this->video_setting['overlay_bg'] ?? null;


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

            $this->dispatch('videoGenerationStarted-' . $this->activeStep->id);
            // }
        } catch (\Exception $e) {
            $this->addError('video', 'Failed to generate video: ');
            // $this->addError('video', 'Failed to generate video: ' . $e->getMessage());
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

    public function setExternalVideoUrl()
    {
        try {
            $this->validate();

            // Extract video ID and generate thumbnail for YouTube
            if (str_contains($this->externalVideoUrl, 'youtube.com') || str_contains($this->externalVideoUrl, 'youtu.be')) {
                $videoId = $this->extractYouTubeVideoId($this->externalVideoUrl);
                if ($videoId) {
                    $this->videoUrl = $this->externalVideoUrl;
                    // Update the step with the external video URL
                    $this->activeStep->update([
                        'video_url' => $this->externalVideoUrl,
                        'is_pipio_processed' => false
                    ]);
                    
                    $this->dispatch('external-video-url-set', [
                        'videoUrl' => $this->videoUrl
                    ]);
                    
                    $this->dispatch('notify', status: 'success', msg: 'External video URL saved successfully!');
                } else {
                    $this->addError('externalVideoUrl', 'Could not extract video ID from YouTube URL');
                }
            } 
            // Extract video ID and generate thumbnail for Vimeo
            elseif (str_contains($this->externalVideoUrl, 'vimeo.com')) {
                $videoId = $this->extractVimeoVideoId($this->externalVideoUrl);
                if ($videoId) {
                    $this->videoUrl = $this->externalVideoUrl;
                    // Update the step with the external video URL
                    $this->activeStep->update([
                        'video_url' => $this->externalVideoUrl,
                        'is_pipio_processed' => false
                    ]);
                    
                    $this->dispatch('external-video-url-set', [
                        'videoUrl' => $this->videoUrl
                    ]);
                    
                    $this->dispatch('notify', status: 'success', msg: 'External video URL saved successfully!');
                } else {
                    $this->addError('externalVideoUrl', 'Could not extract video ID from Vimeo URL');
                }
            } else {
                $this->addError('externalVideoUrl', 'Please enter a valid YouTube or Vimeo URL');
            }
        } catch (\Exception $e) {
            $this->addError('externalVideoUrl', 'Failed to save external video URL: ' . $e->getMessage());
        }
    }

    protected function extractYouTubeVideoId($url)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    protected function extractVimeoVideoId($url)
    {
        $pattern = '/vimeo\.com\/([0-9]+)/';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function clearExternalVideoUrl()
    {
        try {
            $this->externalVideoUrl = '';
            $this->videoUrl = '';
            $this->uploadType = 'upload';
            
            // Update the step to remove the external video URL
            $this->activeStep->update([
                'video_url' => null,
                'is_pipio_processed' => false
            ]);
            
            $this->dispatch('external-video-cache-cleared');
            $this->dispatch('notify', status: 'success', msg: 'External video URL cleared successfully!');
        } catch (\Exception $e) {
            $this->addError('externalVideoUrl', 'Failed to clear external video URL: ' . $e->getMessage());
        }
    }

    public function update_fit_video($key)
    {
        $this->video_setting[$key] =  $this->fit_video;

        $this->activeStep->update([
            'video_setting' => json_encode($this->video_setting),
        ]);
        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
    }
    public function update_position_video($key)
    {
        $this->video_setting[$key] =  $this->position_video;

        $this->activeStep->update([
            'video_setting' => json_encode($this->video_setting),
        ]);
        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
    }

    public function update_overlay_text($key)
    {
        $this->video_setting[$key] =  $this->overlay_text;

        $this->activeStep->update([
            'video_setting' => json_encode($this->video_setting),
        ]);
        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
    }

    public function update_text_size($key)
    {
        $this->video_setting[$key] =  $this->text_size;

        $this->activeStep->update([
            'video_setting' => json_encode($this->video_setting),
        ]);
        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
    }

    public function update_overlay_bg($key)
    {
        $this->video_setting[$key] =  $this->overlay_bg;

        $this->activeStep->update([
            'video_setting' => json_encode($this->video_setting),
        ]);
        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
    }

    // Removed step-level autoplay handling in favor of campaign-level setting
    public function render()
    {
        return view('livewire.video-setup');
    }
}
