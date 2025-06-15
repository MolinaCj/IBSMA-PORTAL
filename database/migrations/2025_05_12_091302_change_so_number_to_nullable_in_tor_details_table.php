<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tor_details', function (Blueprint $table) {
            $table->text('so_number')->nullable()->change();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tor_details', function (Blueprint $table) {
            $table->text('so_number')->nullable(false)->change();
        });
    }
};
