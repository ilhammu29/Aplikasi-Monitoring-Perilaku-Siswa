<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'guru'; // Tentukan nama tabel secara eksplisit
    protected $primaryKey = 'id_guru';
    protected $fillable = ['id_user', 'nip'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function perilaku()
    {
        return $this->hasMany(Perilaku::class, 'id_guru');
    }
}