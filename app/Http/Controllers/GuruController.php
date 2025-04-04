<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Perilaku;
use App\Models\KategoriPerilaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:guru']);
    }

    public function index()
    {
        return view('guru.dashboard');
    }

    public function daftarSiswa()
    {
        $siswas = Siswa::with('user')->get();
        return view('guru.daftar-siswa', compact('siswas'));
    }

    public function showInputPerilakuForm($id_siswa)
    {
        $siswa = Siswa::with('user')->findOrFail($id_siswa);
        $kategoriPerilaku = KategoriPerilaku::all();

        return view('guru.input-perilaku', compact('siswa', 'kategoriPerilaku'));
    }

    public function storePerilaku(Request $request)
{
    $validated = $request->validate([
        'id_siswa' => 'required|exists:siswa,id_siswa',
        'kategori_perilaku_id' => 'required|exists:kategori_perilaku,id',
        'tanggal' => 'required|date',
        'nilai' => 'required|integer|min:1|max:100',
        'komentar' => 'nullable|string|max:500',
    ]);

    DB::beginTransaction();

    try {
        // Dapatkan user yang login
        $user = Auth::user();
        
        // Cari data guru berdasarkan user_id
        $guru = Guru::where('id_user', $user->id)->first();

        if (!$guru) {
            // Jika guru tidak ditemukan, buat record baru (opsional)
            // Atau cukup return error
            throw new \Exception('Data guru tidak ditemukan. Silahkan lengkapi profil guru terlebih dahulu.');
        }

        $kategori = KategoriPerilaku::findOrFail($validated['kategori_perilaku_id']);
        $siswa = Siswa::findOrFail($validated['id_siswa']);

        Perilaku::create([
            'id_siswa' => $siswa->id_siswa,
            'id_guru' => $guru->id_guru,
            'kategori_perilaku_id' => $kategori->id,
            'tanggal' => $validated['tanggal'],
            'nilai' => $validated['nilai'],
            'komentar' => $validated['komentar'] ?? null,
        ]);

        $siswa->increment('poin', $kategori->poin);

        DB::commit();

        return redirect()
            ->route('guru.daftar-siswa')
            ->with('success', 'Perilaku siswa berhasil dicatat dan poin berhasil diupdate.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Gagal menyimpan perilaku: ' . $e->getMessage());

        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}

    public function lihatOrangTua($id_siswa)
    {
        $siswa = Siswa::with('orangTua.user')->findOrFail($id_siswa);
        return view('guru.lihat-orangtua', compact('siswa'));
    }
}