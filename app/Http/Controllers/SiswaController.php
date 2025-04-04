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

        $perilaku = Perilaku::with(['kategoriPerilaku', 'guru.user'])
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

        if (!$siswa) {
            abort(403, 'Data siswa tidak ditemukan');
        }

        $query = Perilaku::with(['kategoriPerilaku', 'guru.user'])
            ->where('id_siswa', $siswa->id_siswa);

        switch (request('sort')) {
            case 'terlama':
                $query->oldest();
                break;

            case 'poin_tertinggi':
                $query->with('kategoriPerilaku')
                      ->get()
                      ->sortByDesc(fn($item) => $item->kategoriPerilaku->poin ?? 0);
                break;

            case 'poin_terendah':
                $query->with('kategoriPerilaku')
                      ->get()
                      ->sortBy(fn($item) => $item->kategoriPerilaku->poin ?? 0);
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

        if ($laporan->id_siswa !== auth()->user()->siswa->id_siswa) {
            abort(403, 'Anda tidak berhak mengomentari laporan ini.');
        }

        $laporan->update(['komentar_siswa' => $request->komentar]);

        return back()->with('success', 'Komentar berhasil disimpan');
    }
}
