<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\KategoriPerilaku;
use App\Models\Perilaku;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function kelolaPengguna()
    {
        $users = User::all();
        return view('admin.kelola-pengguna', compact('users'));
    }

    public function tambahPengguna(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users|max:100',
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,guru,siswa,orang_tua',
        ]);

        User::create([
            'username' => $validated['username'],
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.kelola-pengguna')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function editPengguna(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|max:100|unique:users,username,'.$user->id,
            'nama' => 'required|max:255',
            'email' => 'required|email|max:100|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,guru,siswa,orang_tua',
        ]);

        $user->update($validated);

        return redirect()->route('admin.kelola-pengguna')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function hapusPengguna($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.kelola-pengguna')->with('success', 'Pengguna berhasil dihapus');
    }

    public function daftarSiswa()
    {
        $siswas = Siswa::with('user')->get();
        return view('admin.daftar-siswa', compact('siswas'));
    }

    public function showInputPerilakuForm($id_siswa)
    {
        $siswa = Siswa::findOrFail($id_siswa);
        $kategoriPerilaku = KategoriPerilaku::orderBy('nama')->get();
        return view('admin.input-perilaku', compact('siswa', 'kategoriPerilaku'));
    }

    public function storePerilaku(Request $request)
{
    $validated = $request->validate([
        'id_siswa' => 'required|exists:siswa,id_siswa',
        'kategori_perilaku_id' => 'required|exists:kategori_perilaku,id',
        'tanggal' => 'required|date',
        'nilai' => 'required|integer|min:1|max:100',
        'komentar' => 'nullable|string',
    ]);

    $kategori = KategoriPerilaku::findOrFail($validated['kategori_perilaku_id']);
    $siswa = Siswa::findOrFail($validated['id_siswa']);

    // Simpan data perilaku
    Perilaku::create([
        'id_siswa' => $validated['id_siswa'],
        'id_admin' => auth()->id(),
        'id_guru' => null,
        'kategori_perilaku_id' => $validated['kategori_perilaku_id'],
        'nilai' => $validated['nilai'],
        'tanggal' => $validated['tanggal'],
        'komentar' => $validated['komentar'],
    ]);

    // Update poin siswa
    $siswa->poin += $kategori->poin;
    $siswa->save();

    return redirect()->route('admin.daftar-siswa')
        ->with('success', 'Perilaku siswa berhasil dicatat. Poin berhasil diupdate.');
}
}