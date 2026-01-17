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
        Schema::create('adverts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('item')->index();
            $table->string('advert_category')->index();
            $table->longText('message');
            $table->string('contact')->nullable();
            $table->string('quantity')->nullable();
            $table->date('start_date')->index();
            $table->date('end_date')->index();
            $table->string('file')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adverts');
    }
};
