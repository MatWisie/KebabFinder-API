<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kebab_meat_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kebab_id')->constrained('kebabs')->onDelete('cascade');
            $table->foreignId('meat_type_id')->constrained('meat_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebab_meat_types');
    }
};
