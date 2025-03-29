<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPerilaku extends Model
{
    use HasFactory;
    protected $table = 'laporan_perilaku';
    protected $primaryKey = 'id_laporan';
    protected $fillable = ['id_siswa', 'periode', 'rata_nilai', 'status', 'komentar_siswa'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}