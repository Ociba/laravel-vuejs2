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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('type_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('location_id')->constrained('locations')->onDelete('cascade');
            $table->foreignUuid('country_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('item_name');
            $table->string('slug');
            $table->enum('gender', ['unisex', 'women', 'men', 'children', 'babies'])->default('unisex');
            $table->string('quantity');
            $table->decimal('sales_price', 10, 2);
            $table->string('discount')->default(0);
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->string('description');
            $table->string('size')->nullable();
            $table->string('breed')->nullable();
            $table->string('weight')->nullable();
            $table->string('model')->nullable();
            $table->string('material')->nullable();
            $table->string('measure')->nullable();
            $table->string('number_of_rooms')->nullable();
            $table->string('security')->nullable();
            $table->string('power')->nullable();
            $table->string('water')->nullable();
            $table->string('features')->nullable();
            $table->string('parking')->nullable();
            $table->string('agent_fee')->nullable();
            $table->string('state')->nullable();
            $table->string('conscent')->nullable();
            $table->string('location_status')->nullable();
            $table->string('transmission')->nullable();
            $table->string('fuel')->nullable();
            $table->string('make')->nullable();
            $table->string('steering')->nullable();
            $table->string('number_plate')->nullable();
            $table->string('engine_capacity')->nullable();
            $table->string('top_speed')->nullable();
            $table->string('number_of_cylinders')->nullable();
            $table->string('fuel_capacity')->nullable();
            $table->string('number_of_gears')->nullable();
            $table->string('age')->nullable();
            $table->string('wheel_size')->nullable();
            $table->string('body_type')->nullable();
            $table->string('watts')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('graphic_card')->nullable();
            $table->string('storage_type')->nullable();
            $table->string('processor')->nullable();
            $table->string('storage')->nullable();
            $table->string('ram')->nullable();
            $table->string('sim')->nullable();
            $table->string('display_type')->nullable();
            $table->string('brand_name')->nullable();
            $table->string('condition');
            $table->string('offer');
            $table->string('expiry_date')->nullable();
            $table->string('care_inforamtion')->nullable();
            $table->string('store_information')->nullable();
            $table->string('manufucturing_date')->nullable();
            $table->string('working_hours')->nullable();
            $table->string('photo');
            $table->json('additional_photos')->nullable();
            $table->enum('status', ['available', 'sold', 'stopped'])->default('available');
            $table->foreignUuid('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('updated_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();

            $table->index('item_name');
            $table->index('category_id');
            $table->index('type_id');
            $table->index('created_by');
            $table->index('slug');
            $table->index('registration_id');
            $table->index('location_id');
            $table->index('country_id');
            $table->index('updated_by');
            $table->index('status');
            $table->index('offer');
            $table->index('gender');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
