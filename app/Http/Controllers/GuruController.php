<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
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
        $this->middleware('auth');
        $this->middleware('role:guru');
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
        
        return view('guru.input-perilaku', [
            'siswa' => $siswa,
            'kategoriPerilaku' => $kategoriPerilaku
        ]);
    }

    public function storePerilaku(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'kategori_perilaku_id' => 'required|exists:kategori_perilaku,id',
            'tanggal' => 'required|date',
            'nilai' => 'required|integer|min:1|max:100',
            'komentar' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            $guru = Auth::user()->guru;
            
            if (!$guru) {
                throw new \Exception('Data guru tidak ditemukan');
            }

            $kategori = KategoriPerilaku::findOrFail($request->kategori_perilaku_id);
            $siswa = Siswa::findOrFail($request->id_siswa);

            // Simpan data perilaku
            $perilaku = Perilaku::create([
                'id_siswa' => $request->id_siswa,
                'id_guru' => $guru->id_guru,
                'kategori_perilaku_id' => $request->kategori_perilaku_id,
                'tanggal' => $request->tanggal,
                'nilai' => $request->nilai,
                'komentar' => $request->komentar,
            ]);

            // Update poin siswa
            $siswa->poin += $kategori->poin;
            $siswa->save();

            DB::commit();

            return redirect()->route('guru.daftar-siswa')
                ->with('success', 'Perilaku siswa berhasil dicatat. Poin berhasil diupdate.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error menyimpan perilaku: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function lihatOrangTua($id_siswa)
    {
        $siswa = Siswa::with('orangTua.user')->findOrFail($id_siswa);
        return view('guru.lihat-orangtua', compact('siswa'));
    }
}