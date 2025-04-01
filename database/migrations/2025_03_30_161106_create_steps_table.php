<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->string('name');
            $table->text('video')->nullable();
            $table->json('video_setting')->nullable();
            $table->integer('position');
            $table->json('next_steps')->nullable();
            $table->json('form')->nullable();
            $table->json('multi_choice_question')->nullable();
            $table->json('multi_choice_setting')->nullable();
            $table->enum('answer_type', ['open_ended', 'ai_chat', 'multi_choice', 'button', 'calender', 'live_call', 'NPS' , 'file_upload', 'payment'])->default('open_ended');
            $table->boolean('allow_video_response')->default(false);
            $table->boolean('allow_audio_response')->default(false);
            $table->boolean('allow_text_response')->default(false);
            $table->boolean('contact_detail')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steps');
    }
};
