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
        Schema::create('kebabmeattypes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kebab_id')->constrained('kebabs')->onDelete('cascade');
            $table->foreignId('meat_type_id')->constrained('meattypes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebabmeattypes');
    }
};
