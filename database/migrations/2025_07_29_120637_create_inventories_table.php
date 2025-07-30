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
    Schema::create('inventories', function (Blueprint $table) {
        $table->id();
        $table->string('name');  // Add name column
        $table->decimal('price', 8, 2);  // Add price column
        $table->integer('quantity');  // Add quantity column
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
