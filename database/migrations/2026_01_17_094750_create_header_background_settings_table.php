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
        Schema::create('header_background_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['text', 'background', 'btn', 'border', 'frbg1', 'ftext', 'fbtn', 'frbg2', 'header', 'htext', 'hbtn', 'default-color', 'chatbg', 'chattext', 'chatbtn']);
            $table->string('value'); // color code or btn
            $table->enum('status', ['is_active', 'is_not_active'])->default('is_not_active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_background_settings');
    }
};
