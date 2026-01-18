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
        Schema::create('call_back_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('requested_by');
            $table->string('phone');
            $table->enum('status', ['pending', 'read'])->default('pending')->index();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['product_id', 'owner_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_back_requests');
    }
};
