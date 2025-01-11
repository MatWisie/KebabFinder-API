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
        Schema::create('kebabs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('coordinates');
            $table->string('logo_link')->nullable();
            $table->year('open_year')->nullable();
            $table->year('closed_year')->nullable();
            $table->enum('status',['open','closed','planned']);
            $table->boolean('is_craft');
            $table->string('building_type');
            $table->boolean('is_chain');
            $table->double('google_review')->nullable();
            $table->string('pyszne_pl_link')->nullable();
            $table->double('pyszne_pl_review')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebabs');
    }
};
