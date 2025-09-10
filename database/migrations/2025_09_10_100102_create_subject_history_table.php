<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subject_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_id')->constrained()->onDelete('cascade');
            $table->string('subject_code');
            $table->string('subject_name')->nullable();
            $table->integer('units')->nullable();
            $table->string('academic_year_range');
            $table->string('semester'); // ✨ ADDED THIS LINE
            $table->string('action'); // 'added' or 'removed'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject_history');
    }
};