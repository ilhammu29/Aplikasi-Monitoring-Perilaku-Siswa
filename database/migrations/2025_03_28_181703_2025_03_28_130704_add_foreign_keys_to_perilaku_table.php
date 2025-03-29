<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus constraint yang sudah ada (jika ada)
        $this->dropExistingForeignKeys();

        // Tambahkan constraint baru dengan nama unik
        Schema::table('perilaku', function (Blueprint $table) {
            $table->foreign('id_siswa', 'fk_perilaku_siswa_v2')
                  ->references('id_siswa')
                  ->on('siswa')
                  ->onDelete('cascade');

            $table->foreign('id_guru', 'fk_perilaku_guru_v2')
                  ->references('id_guru')
                  ->on('guru')
                  ->onDelete('cascade');

            $table->foreign('kategori_perilaku_id', 'fk_perilaku_kategori_v2')
                  ->references('id')
                  ->on('kategori_perilaku')
                  ->onDelete('cascade');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down()
    {
        Schema::table('perilaku', function (Blueprint $table) {
            $table->dropForeign('fk_perilaku_siswa_v2');
            $table->dropForeign('fk_perilaku_guru_v2');
            $table->dropForeign('fk_perilaku_kategori_v2');
        });
    }

    protected function dropExistingForeignKeys()
    {
        $foreignKeys = [
            'perilaku_id_siswa_foreign',
            'perilaku_id_guru_foreign',
            'perilaku_kategori_perilaku_id_foreign',
            // Tambahkan nama constraint lain yang mungkin ada
        ];

        foreach ($foreignKeys as $foreignKey) {
            try {
                Schema::table('perilaku', function (Blueprint $table) use ($foreignKey) {
                    $table->dropForeign($foreignKey);
                });
            } catch (\Exception $e) {
                // Constraint mungkin tidak ada, lanjutkan saja
                continue;
            }
        }
    }
};