<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perilaku extends Model
{
    use HasFactory;

    protected $table = 'perilaku';
    protected $primaryKey = 'id_perilaku';
    
    protected $fillable = [
        'id_siswa',
        'id_guru',
        'kategori_perilaku_id',
        'tanggal',
        'nilai',
        'komentar'
    ];

    protected $casts = [
        'tanggal' => 'date',
        // tambahkan cast lainnya jika perlu
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPerilaku::class, 'kategori_perilaku_id');
    }

    public function perilaku()
{
    return $this->hasMany(Perilaku::class, 'id_siswa')->with('kategori', 'guru.user');
}
}