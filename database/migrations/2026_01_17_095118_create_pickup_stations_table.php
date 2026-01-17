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
        Schema::create('pickup_stations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('delivery_fees_id')->constrained()->onDelete('cascade');
            $table->string('station_name')->index();
            $table->string('station_contact');
            $table->text('station_location');
            $table->foreignUuid('created_by')->constrained('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['delivery_fees_id', 'created_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickup_stations');
    }
};
