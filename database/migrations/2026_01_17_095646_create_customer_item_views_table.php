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
        Schema::create('customer_item_views', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignUuid('product_id')->constrained()->onDelete('cascade');
            $table->uuid('visitor_id')->nullable()->index();
            $table->string('ip_address')->nullable();
            $table->string('session_id')->nullable();
            $table->string('device')->nullable();
            $table->enum('status', ['pending', 'seen'])->default('pending')->index();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['product_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_item_views');
    }
};
