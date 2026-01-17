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
        Schema::create('sent_email_updates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('subject');
            $table->longText('message');
            $table->integer('recipient_count')->default(0);
            $table->boolean('sent_to_sellers')->default(0)->index();
            $table->boolean('sent_to_subscribers')->default(0)->index();
            $table->json('failed_recipients')->nullable();
            $table->foreignUuid('created_by')->constrained('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();

            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sent_email_updates');
    }
};
