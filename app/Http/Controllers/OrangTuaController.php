<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Perilaku;
use App\Models\LaporanPerilaku;
use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:orang_tua');
    }

    public function index()
    {
        // Ambil data siswa yang terkait dengan orang tua
        $siswa = auth()->user()->orangTua->siswa;
        
        // Ambil 5 catatan perilaku terbaru
        $perilakuTerbaru = Perilaku::with(['kategori', 'guru.user'])
            ->where('id_siswa', $siswa->id_siswa)
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        // Ambil laporan periodik
        $laporanPeriodik = LaporanPerilaku::where('id_siswa', $siswa->id_siswa)
            ->orderBy('periode', 'desc')
            ->get();

        return view('orangtua.dashboard', [
            'siswa' => $siswa,
            'perilakuTerbaru' => $perilakuTerbaru,
            'laporanPeriodik' => $laporanPeriodik
        ]);
    }

    public function semuaPerilaku()
    {
        $siswa = auth()->user()->orangTua->siswa;
        
        $semuaPerilaku = Perilaku::with(['kategori', 'guru.user'])
            ->where('id_siswa', $siswa->id_siswa)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('orangtua.semua-perilaku', [
            'siswa' => $siswa,
            'semuaPerilaku' => $semuaPerilaku
        ]);
    }
}