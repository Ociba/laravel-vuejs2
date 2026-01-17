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
        Schema::create('missing_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('item')->index();
            $table->string('ip_address')->nullable()->after('item');
            $table->text('user_agent')->nullable()->after('ip_address');
            $table->boolean('is_suspicious')->default(false)->after('user_agent')->index();
            $table->text('detection_reason')->nullable()->after('is_suspicious');
            $table->timestamp('submitted_at')->nullable()->after('detection_reason')->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missing_items');
    }
};
