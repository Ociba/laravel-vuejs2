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
        Schema::create('adcharges', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('offer')->index();
            $table->decimal('charge', 10, 2);
            $table->boolean('is_trial_eligible')->default(0)->index(); // optional index if filtered often
            $table->enum('status', ['active', 'paused'])->default('active')->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adcharges');
    }
};
