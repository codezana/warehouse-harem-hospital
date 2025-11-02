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
        Schema::create('total_purchase', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->decimal('order_tax_total', 10, 2);
            $table->decimal('discount_total', 10, 2);
            $table->decimal('shipping_total', 10, 2);
            $table->integer('dolar_price')->nullable();

            $table->decimal('grand_total', 10, 2);
            $table->decimal('paid', 10, 2);
            $table->decimal('grand_dinar', 10, 2);
            $table->decimal('paid_dinar', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('total_purchase');
    }
};
