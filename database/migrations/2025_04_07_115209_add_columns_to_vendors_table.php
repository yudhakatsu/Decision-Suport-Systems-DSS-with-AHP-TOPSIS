<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('username')->after('id')->nullable();
            $table->string('password')->after('username')->nullable();
            $table->text('background_vendor')->after('password')->nullable();
            $table->decimal('nilai_akhir', 8, 4)->after('background_vendor')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['username', 'password', 'background_vendor', 'nilai_akhir']);
        });
    }
};
