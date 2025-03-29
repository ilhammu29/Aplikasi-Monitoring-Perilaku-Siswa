<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    protected $fillable = [
        'id_user',
        'nomor_induk',
        'kelas',
        'jurusan',
        'poin' // Tambahkan ini
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'id_siswa');
    }

    public function perilaku()
    {
        return $this->hasMany(Perilaku::class, 'id_siswa');
    }

    public function laporanPerilaku()
    {
        return $this->hasMany(LaporanPerilaku::class, 'id_siswa');
    }

    public function updatePoin($perubahan)
{
    $this->poin += $perubahan;
    $this->save();
    
    return $this;
}
}