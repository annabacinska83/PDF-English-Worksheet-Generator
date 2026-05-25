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
        Schema::create('match_the_pairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_id')->constrained()->onDelete('cascade');
            $table->string('left');
            $table->string('right');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_the_pairs');
    }
};
