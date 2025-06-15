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
        Schema::create('tor_details', function (Blueprint $table) {
            $table->id();
            $table->string('student_id'); 
            $table->foreign('student_id')
                  ->references('student_id') // Make sure students table has student_id as primary key
                  ->on('students')
                  ->onDelete('cascade');
            $table->boolean('transferee')->default(false);
            $table->date('date_of_admission');
            $table->string('credential');
            $table->date('date_of_graduation')->nullable();
            $table->string('student_picture')->nullable();
            $table->string('so_number');
            $table->string('purpose');
            $table->text('remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tor_details');
    }
};
