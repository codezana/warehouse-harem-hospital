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
        Schema::create('sale_order_return', function (Blueprint $table) {
            $table->id();
            $table->decimal('shipping', 17, 2)->nullable(); 
            $table->string('status')->nullable(); 
            $table->integer('dolar_price')->after('status')->nullable();
            $table->decimal('total_dinar', 20, 2); 
            $table->decimal('total_dollar', 20, 2); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_order_return');
    }
};
