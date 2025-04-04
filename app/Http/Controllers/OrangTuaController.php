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
        $orangTua = auth()->user()->orangTua;

$siswa = $orangTua?->siswas?->first();

if (!$siswa) {
    return view('orangtua.semua-perilaku', [
        'siswa' => null,
        'semuaPerilaku' => collect([]), // ✅ Aman dan bisa pakai ->count()
    ]);
    
}

    
     
    
        $siswas = $orangTua->siswas;

        if (!$siswas || $siswas->isEmpty()) {
            return view('orangtua.dashboard', [
                'siswa' => null,
                'perilakuTerbaru' => [],
                'laporanPeriodik' => [],
            ])->with('warning', 'Belum ada siswa yang terhubung.');
        }
        
    
        $siswa = $siswas->first();
    
        $perilakuTerbaru = Perilaku::with(['kategori', 'guru.user'])
            ->where('id_siswa', $siswa->id_siswa)
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();
    
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
    $orangTua = auth()->user()->orangTua;
    $siswa = $orangTua?->siswas?->first();

    if (!$siswa) {
        return view('orangtua.semua-perilaku', [
            'siswa' => null,
            'semuaPerilaku' => collect(), // ✅ ganti dari array ke collection
        ])->with('warning', 'Belum ada siswa yang terhubung.');
    }

    $semuaPerilaku = Perilaku::with(['kategori', 'guru.user'])
        ->where('id_siswa', $siswa->id_siswa)
        ->orderBy('tanggal', 'desc')
        ->paginate(10); // ini object paginator (punya method count)

    return view('orangtua.semua-perilaku', [
        'siswa' => $siswa,
        'semuaPerilaku' => $semuaPerilaku
    ]);
}

}