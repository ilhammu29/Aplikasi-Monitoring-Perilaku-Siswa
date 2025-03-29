<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Pastikan menggunakan engine InnoDB
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('perilaku', function (Blueprint $table) {
            $table->id('id_perilaku');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_guru');
            $table->unsignedBigInteger('kategori_perilaku_id');
            $table->date('tanggal');
            $table->integer('nilai');
            $table->text('komentar')->nullable();
            $table->timestamps();

            // Tambahkan index dulu
            $table->index('id_siswa');
            $table->index('id_guru');
            $table->index('kategori_perilaku_id');

            // Set engine ke InnoDB
            $table->engine = 'InnoDB';
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down()
    {
        Schema::dropIfExists('perilaku');
    }
};