<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the ENUM values for the funnel column to include all required values
        DB::statement("ALTER TABLE products MODIFY COLUMN funnel ENUM('FE', 'OTO1', 'OTO2', 'OTO3', 'OTO4', 'OTO5', 'OTO6', 'OTO7', 'OTO8', 'Bundle') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to the original ENUM values
        DB::statement("ALTER TABLE products MODIFY COLUMN funnel ENUM('FE', 'OTO1', 'OTO4', 'OTO5', 'OTO6', 'Bundle') NOT NULL");
    }
};
