<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\KategoriPerilaku;
use App\Models\Perilaku;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin
        $admin = User::create([
            'username' => 'admin',
            'nama' => 'Administrator',
            'email' => 'admin@smkn1sambas.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Guru
        $guruUser = User::create([
            'username' => 'guru1',
            'nama' => 'Guru Pertama',
            'email' => 'guru1@smkn1sambas.ac.id',
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);

        $guru = Guru::create([
            'id_user' => $guruUser->id,
            'nip' => '1234567890',
        ]);

        // Siswa
        $siswaUser = User::create([
            'username' => 'siswa1',
            'nama' => 'Siswa Pertama',
            'email' => 'siswa1@smkn1sambas.ac.id',
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);

        $siswa = Siswa::create([
            'id_user' => $siswaUser->id,
            'nomor_induk' => '2023001',
            'kelas' => 'XII TAV',
            'jurusan' => 'Teknik Audio Video',
            'poin' => 0,
        ]);

        // Kategori Perilaku
        $kategori1 = KategoriPerilaku::create([
            'nama' => 'Kedisiplinan',
            'poin' => 10,
            'deskripsi' => 'Perilaku terkait kedisiplinan'
        ]);

        $kategori2 = KategoriPerilaku::create([
            'nama' => 'Keaktifan',
            'poin' => 5,
            'deskripsi' => 'Perilaku terkait partisipasi aktif'
        ]);

        $kategori3 = KategoriPerilaku::create([
            'nama' => 'Pelanggaran Ringan',
            'poin' => -5,
            'deskripsi' => 'Pelanggaran ringan'
        ]);

        // Data Perilaku Contoh
        Perilaku::create([
            'id_siswa' => $siswa->id_siswa,
            'id_guru' => $guru->id_guru,
            'kategori_perilaku_id' => $kategori1->id,
            'tanggal' => now()->subDays(7),
            'nilai' => 85,
            'komentar' => 'Siswa sangat disiplin dalam mengikuti pelajaran',
        ]);

        // Update poin siswa
        $siswa->poin += $kategori1->poin;
        $siswa->save();

        // Orang Tua
$orangTuaUser = User::create([
    'username' => 'ortu1',
    'nama' => 'Orang Tua Siswa',
    'email' => 'ortu1@example.com',
    'password' => bcrypt('password'),
    'role' => 'orang_tua',
]);

// Ambil siswa pertama yang sudah dibuat
$siswa = Siswa::first(); 

OrangTua::create([
    'id_user' => $orangTuaUser->id,
    'id_siswa' => $siswa->id_siswa,
]);
    }

    
}