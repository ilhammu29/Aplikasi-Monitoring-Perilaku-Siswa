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
use App\Events\PerilakuBaruDitambahkan;
use App\Notifications\NotifikasiPerilakuBaru;
use App\Models\User; // Untuk Laravel 8+
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
        $user = Auth::user();
        $guru = Guru::where('id_user', $user->id)->firstOrFail();
        $kategori = KategoriPerilaku::findOrFail($validated['kategori_perilaku_id']);
        $siswa = Siswa::findOrFail($validated['id_siswa']);

        $perilaku = Perilaku::create([
            'id_siswa' => $siswa->id_siswa,
            'id_guru' => $guru->id_guru,
            'kategori_perilaku_id' => $kategori->id,
            'tanggal' => $validated['tanggal'],
            'nilai' => $validated['nilai'],
            'komentar' => $validated['komentar'] ?? null,
        ]);

        // Update poin siswa
        $siswa->poin += $kategori->poin;
        $siswa->save();

        // Cari orang tua siswa
        $orangTua = User::whereHas('siswa', function($query) use ($siswa) {
            $query->where('id_siswa', $siswa->id_siswa);
        })->first();

        // Data notifikasi
        $notificationData = [
            'siswa_id' => $siswa->id_siswa,
            'siswa_nama' => $siswa->user->nama,
            'kelas' => $siswa->kelas,
            'jurusan' => $siswa->jurusan,
            'perilaku_kategori' => $kategori->nama,
            'poin_kategori' => $kategori->poin,
            'nilai' => $validated['nilai'],
            'guru_nama' => $guru->user->nama,
            'tanggal' => $validated['tanggal'],
            'komentar' => $validated['komentar'] ?? '-',
            'total_poin' => $siswa->poin,
            'orangtua_id' => $orangTua ? $orangTua->id : null,
            'action_url' => [
                'siswa' => route('siswa.semua-perilaku'),
                'orangtua' => route('orangtua.semua-perilaku'),
            ]
        ];

        event(new PerilakuBaruDitambahkan($notificationData));

        DB::commit();

        return redirect()
            ->route('guru.daftar-siswa')
            ->with('success', 'Perilaku siswa berhasil dicatat dan notifikasi telah dikirim.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Gagal menyimpan perilaku: ' . $e->getMessage());

        return back()
            ->withInput()
            ->with('error', 'Gagal menyimpan data perilaku: ' . $e->getMessage());
    }
}

    public function lihatOrangTua($id_siswa)
    {
        $siswa = Siswa::with('orangTua.user')->findOrFail($id_siswa);
        return view('guru.lihat-orangtua', compact('siswa'));
    }
}
