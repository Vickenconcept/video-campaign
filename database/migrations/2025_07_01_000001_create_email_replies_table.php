<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('email_replies', function (Blueprint $table) {
            $table->id();
            $table->uuid('email_recipient_id');
            $table->foreign('email_recipient_id')->references('uuid')->on('email_recipients')->onDelete('cascade');
            $table->text('message');
            $table->string('sender_name')->nullable();
            $table->string('sender_email')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_replies');
    }
}; 