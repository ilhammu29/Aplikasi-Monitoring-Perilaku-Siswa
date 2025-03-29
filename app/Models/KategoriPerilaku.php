<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPerilaku extends Model
{
    use HasFactory;
    protected $table = 'kategori_perilaku';

    protected $fillable = ['nama', 'poin', 'deskripsi'];
}