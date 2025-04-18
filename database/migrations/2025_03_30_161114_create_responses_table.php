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
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('step_id')->constrained('steps')->onDelete('cascade');
            $table->string('user_token')->nullable();
            $table->text('video')->nullable();
            $table->text('audio')->nullable();
            $table->text('text')->nullable();
            $table->string('name')->nullable();
            $table->text('email')->nullable();
            $table->string('phonenumber', 20)->nullable();
            $table->text('productname')->nullable();
            $table->text('additionaltext')->nullable();
            $table->boolean('consent')->default(false);
            $table->text('multi_option_response')->nullable();
            $table->text('file_upload')->nullable();
            $table->string('nps_score')->nullable();
            $table->string('type')->default('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
