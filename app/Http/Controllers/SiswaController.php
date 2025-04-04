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
        $siswa = auth()->user()->siswa;

        if (!$siswa) {
            abort(403, 'Data siswa tidak ditemukan');
        }

        $perilaku = Perilaku::with(['kategori', 'guru.user'])
            ->where('id_siswa', $siswa->id_siswa)
            ->latest()
            ->take(5)
            ->get();

        $laporan = LaporanPerilaku::where('id_siswa', $siswa->id_siswa)
            ->latest()
            ->get();

        return view('siswa.dashboard', compact('siswa', 'perilaku', 'laporan'));
    }

    public function semuaPerilaku()
    {
        $siswa = auth()->user()->siswa;

        $query = Perilaku::with(['kategori', 'guru.user'])
            ->where('id_siswa', $siswa->id_siswa);

        switch (request('sort')) {
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
            default:
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
