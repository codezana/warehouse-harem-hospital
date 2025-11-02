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
        Schema::create('system_expiration', function (Blueprint $table) {
            $table->id();
            $table->date('expiration_date');
            $table->timestamps();
               // Ensure that only one row can exist in this table
               $table->unique(['id', 'expiration_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_expiration');
    }
};
