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
        Schema::table('message', function (Blueprint $table) {
            $table->timestamps(); // Menambah created_at & updated_at
        });
    }

    public function down()
    {
        Schema::table('message', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
