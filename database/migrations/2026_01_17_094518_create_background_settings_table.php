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
        Schema::create('background_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['image', 'color'])->index();
            $table->string('value'); // image path or color code
            $table->boolean('is_active')->default(false)->index();
            $table->integer('display_order')->default(1)->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('background_settings');
    }
};
