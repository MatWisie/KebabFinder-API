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
        Schema::create('kebabsocialmedias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kebab_Id')->constrained('kebabs')->onDelete('cascade');
            $table->string('social_media_link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebabsocialmedias');
    }
};
