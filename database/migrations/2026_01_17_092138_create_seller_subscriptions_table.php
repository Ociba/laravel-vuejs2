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
        Schema::create('seller_subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('plan_name');
            $table->date('start_date')->index(); // optional
            $table->date('end_date')->index();
            $table->string('status')->default('active');
            $table->boolean('is_trial')->default(0)->index(); // optional
            $table->softDeletes();
            $table->timestamps();

            // Composite index
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_subscriptions');
    }
};
