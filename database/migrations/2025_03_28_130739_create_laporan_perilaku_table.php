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
        Schema::create('laporan_perilaku', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa');
            $table->string('periode', 50);
            $table->decimal('rata_nilai', 5, 2);
            $table->enum('status', ['baik', 'cukup', 'buruk']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_perilaku');
    }
};
