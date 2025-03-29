<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('perilaku', function (Blueprint $table) {
        // Hapus foreign key jika ada
        $table->dropForeign(['id_admin']);
        $table->dropColumn('id_admin');
        
        // Pastikan id_guru tidak nullable
        $table->unsignedBigInteger('id_guru')->nullable(false)->change();
        $table->foreign('id_guru')->references('id_guru')->on('guru');
    });
}

public function down()
{
    Schema::table('perilaku', function (Blueprint $table) {
        $table->dropForeign(['id_guru']);
        $table->unsignedBigInteger('id_guru')->nullable()->change();
        
        $table->unsignedBigInteger('id_admin')->nullable();
        $table->foreign('id_admin')->references('id')->on('users');
    });
}
};
