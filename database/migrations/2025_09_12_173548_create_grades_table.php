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
        Schema::create('grades', function (Blueprint $table) {
            $table->id(); // Use Laravel's default 'id' primary key
            $table->unsignedBigInteger('subject_id')->unique(); // The foreign key to the subjects table
            $table->integer('aae');
            $table->integer('evaluation');
            $table->integer('assignment');
            $table->integer('exam');
            $table->timestamps();

            // Defines the relationship between the 'grades' and 'subjects' tables
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};