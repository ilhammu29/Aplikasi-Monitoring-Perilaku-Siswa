<?php

namespace App\Http\Controllers;

use App\Models\Perilaku;
use App\Models\LaporanPerilaku;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:siswa');
    }

    public function index()
    {
        // Ambil data siswa yang sedang login dengan relasi yang diperlukan
        $siswa = auth()->user()->siswa;
        
        // Validasi jika data siswa tidak ditemukan
        if (!$siswa) {
            abort(403, 'Data siswa tidak ditemukan');
        }

        // Ambil 5 catatan perilaku terbaru dengan relasi
        $perilaku = Perilaku::with(['kategori', 'guru.user'])
            ->where('id_siswa', $siswa->id_siswa)
            ->latest()
            ->take(5)
            ->get();

        // Ambil laporan perilaku
        $laporan = LaporanPerilaku::where('id_siswa', $siswa->id_siswa)
            ->latest()
            ->get();

        // Kirim semua data ke view termasuk $siswa
        return view('siswa.dashboard', compact('siswa', 'perilaku', 'laporan'));
    }

    public function semuaPerilaku()
{
    $siswa = auth()->user()->siswa;
    
    $query = Perilaku::with(['kategori', 'guru.user'])
        ->where('id_siswa', $siswa->id_siswa);
    
    // Sorting
    switch(request('sort')) {
        case 'terlama':
            $query->oldest();
            break;
        case 'poin_tertinggi':
            $query->join('kategori_perilaku', 'perilaku.kategori_perilaku_id', '=', 'kategori_perilaku.id')
                ->orderBy('kategori_perilaku.poin', 'desc');
            break;
        case 'poin_terendah':
            $query->join('kategori_perilaku', 'perilaku.kategori_perilaku_id', '=', 'kategori_perilaku.id')
                ->orderBy('kategori_perilaku.poin', 'asc');
            break;
        default: // terbaru
            $query->latest();
    }
    
    $semuaPerilaku = $query->paginate(10);

    return view('siswa.semua-perilaku', compact('siswa', 'semuaPerilaku'));
}

    public function beriKomentar(Request $request, $id_laporan)
    {
        $request->validate([
            'komentar' => 'required|string|max:255',
        ]);

        $laporan = LaporanPerilaku::findOrFail($id_laporan);
        $laporan->update(['komentar_siswa' => $request->komentar]);

        return back()->with('success', 'Komentar berhasil disimpan');
    }
}