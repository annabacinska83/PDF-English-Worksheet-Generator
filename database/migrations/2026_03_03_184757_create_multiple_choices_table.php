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
        Schema::create('multiple_choices', function (Blueprint $table) {
            $table->id('exercise_id');
            $table->foreignId('worksheet_id')->constrained('worksheets', 'worksheet_id')->onDelete('cascade');
            $table->string('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multiple_choices');
    }
};
