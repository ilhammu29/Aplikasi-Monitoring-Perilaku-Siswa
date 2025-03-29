<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus migrasi yang bermasalah jika masih ada
        Schema::table('perilaku', function (Blueprint $table) {
            // Cek jika kolom kategori masih ada, maka hapus
            if (Schema::hasColumn('perilaku', 'kategori')) {
                $table->dropColumn('kategori');
            }

            // Pastikan kolom kategori_perilaku_id ada
            if (!Schema::hasColumn('perilaku', 'kategori_perilaku_id')) {
                $table->unsignedBigInteger('kategori_perilaku_id')->after('id_guru');
                $table->foreign('kategori_perilaku_id')
                      ->references('id')
                      ->on('kategori_perilaku')
                      ->onDelete('cascade');
            }
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down()
    {
        // Tidak perlu rollback untuk perbaikan
    }
};