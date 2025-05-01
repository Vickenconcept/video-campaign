<?php

namespace App\Livewire;

use App\Models\Response;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Attributes\On;
use Cloudinary\Cloudinary;
use Illuminate\Support\Str;

class SingleResponse extends Component
{

    use WithFileUploads;

    public $response;

    public $videoResponse, $textResponse, $audioResponse;

    public function mount($uuid)
    {


        $this->response = Response::where('uuid', $uuid)->firstOrFail();
    }

    public function saveText()
    {
        Response::create([
            'step_id' =>  $this->response->step_id,
            'uuid' => Str::uuid(),
            'user_token' => $this->response->user_token,
            'email' =>  $this->response->email,
            'name' =>  $this->response->name,
            'phonenumber' =>  $this->response->phonenumber,
            'text' => $this->textResponse,
        ]);

        redirect('thankyou');
    }


    public function saveVideo()
    {

        if (!$this->videoResponse) {
            return response()->json(['error' => 'No video file uploaded'], 400);
        }

        $cloudinary = new Cloudinary();
        $cloudinaryResponse = $cloudinary->uploadApi()->upload($this->videoResponse->getRealPath(), [
            'resource_type' => 'video',
            'folder' => 'videos',
        ]);
        $cloudinaryUrl = $cloudinaryResponse['secure_url'];



        Response::create([
            'step_id' =>  $this->response->step_id,
            'uuid' => Str::uuid(),
            'user_token' => $this->response->user_token,
            'email' =>  $this->response->email,
            'name' =>  $this->response->name,
            'phonenumber' =>  $this->response->phonenumber,
            'video' => $cloudinaryUrl,
        ]);

        // redirect('thankyou');
    }

    public function saveAudio()
    {

        if (!$this->audioResponse) {
            return response()->json(['error' => 'No audio file uploaded'], 400);
        }


        $cloudinary = new Cloudinary();


        $cloudinaryResponse = $cloudinary->uploadApi()->upload($this->audioResponse->getRealPath(), [
            'resource_type' => 'video',
            'folder' => 'audios',
        ]);
        $cloudinaryUrl = $cloudinaryResponse['secure_url'];

        Response::create([
            'step_id' =>  $this->response->step_id,
            'uuid' => Str::uuid(),
            'user_token' => $this->response->user_token,
            'email' =>  $this->response->email,
            'name' =>  $this->response->name,
            'phonenumber' =>  $this->response->phonenumber,
            'audio' => $cloudinaryUrl,
        ]);

        // redirect('thankyou');

    }

    public function sendFeedback(){
        sleep(2);

        redirect('thankyou');
    }




    public function render()
    {
        return view('livewire.single-response')->layout('layouts.custom');
    }
}
