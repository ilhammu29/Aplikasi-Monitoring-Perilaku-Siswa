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
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropForeign(['orang_tua_id']);
            $table->dropColumn('orang_tua_id');
        });
    }
    
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->unsignedBigInteger('orang_tua_id')->nullable()->after('id_siswa');
            $table->foreign('orang_tua_id')->references('id')->on('orang_tua');
        });
    }
    
};
