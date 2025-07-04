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
        Schema::create('former_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('student_id'); 
            $table->foreign('student_id')
                  ->references('student_id') // Make sure students table has student_id as primary key
                  ->on('students')
                  ->onDelete('cascade');
            $table->integer('year');
            $table->integer('semester');
            $table->string('code'); 
            $table->text('title');
            $table->decimal('grade', 5, 2);
            $table->integer('credits'); 
            $table->string('remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('former_subjects');
    }
};
