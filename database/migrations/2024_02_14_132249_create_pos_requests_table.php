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
        Schema::create('pos_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->string('receipt')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->string('order')->unique(); 
            $table->unsignedBigInteger('request_id')->default(0);
            $table->boolean('is_active')->default(1);
            $table->unsignedBigInteger('size_id')->nullable();

            $table->foreign('size_id')->references('id')->on('sizes');


            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('customer_id')->references('id')->on('customers');
        }); }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_requests');
    }
};
