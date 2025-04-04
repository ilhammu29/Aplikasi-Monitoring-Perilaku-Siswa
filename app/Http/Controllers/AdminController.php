<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\KategoriPerilaku;
use App\Models\Perilaku;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
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
        // Validasi umum
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,dosen,siswa',
        ]);
    
        // Tambahan validasi untuk siswa
        if ($request->role === 'siswa') {
            $request->validate([
                'nomor_induk' => 'required|unique:siswa,nomor_induk',
                'kelas' => 'required|string|max:50',
                'jurusan' => 'required|string|max:100',
            ]);
        }
    
        // Buat user baru
        $user = User::create([
            'username' => $validated['username'],
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);
    
        // Kalau siswa, buat data tambahan ke tabel siswa
        if ($user->role === 'siswa') {
            Siswa::create([
                'id_user' => $user->id,
                'nomor_induk' => $request->nomor_induk,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
                'poin' => 100,
            ]);
        }
    
        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
    }
    

    public function editPengguna(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Validasi umum
    $validated = $request->validate([
        'username' => 'required|max:100|unique:users,username,' . $user->id,
        'nama' => 'required|max:255',
        'email' => 'required|email|max:100|unique:users,email,' . $user->id,
        'role' => 'required|in:admin,guru,siswa,orang_tua',
    ]);

    // Update data user
    $user->update($validated);

    // Kalau role-nya siswa, validasi dan update juga data siswa-nya
    if ($request->role === 'siswa') {
        $request->validate([
            'nomor_induk' => [
                'required',
                Rule::unique('siswa', 'nomor_induk')->ignore($user->id, 'id_user'),
            ],
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:100',
        ]);
        
        // Kalau data siswa-nya belum ada (jaga-jaga), kita buat
        if (!$user->siswa) {
            $user->siswa()->create([
                'nomor_induk' => $request->nomor_induk,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
                'poin' => 100,
            ]);
        } else {
            // Kalau udah ada, kita update
            $user->siswa->update([
                'nomor_induk' => $request->nomor_induk,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
            ]);
        }

    } else {
        // Kalau role-nya bukan siswa dan data siswa-nya ada, hapus aja
        if ($user->siswa) {
            $user->siswa()->delete();
        }
    }

    return redirect()->route('admin.kelola-pengguna')->with('success', 'Pengguna berhasil diperbarui.');
}


    public function hapusPengguna($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.kelola-pengguna')->with('success', 'Pengguna berhasil dihapus.');
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
        $gurus = User::where('role', 'guru')->get();

        return view('admin.input-perilaku', compact('siswa', 'kategoriPerilaku', 'gurus'));
    }

    public function storePerilaku(Request $request)
    {
        $validated = $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'kategori_perilaku_id' => 'required|exists:kategori_perilaku,id',
            'tanggal' => 'required|date',
            'nilai' => 'required|integer|min:1|max:100',
            'komentar' => 'nullable|string',
            'id_guru' => 'nullable|exists:users,id',
        ]);

        $kategori = KategoriPerilaku::findOrFail($validated['kategori_perilaku_id']);
        $siswa = Siswa::findOrFail($validated['id_siswa']);

        Perilaku::create([
            'id_siswa' => $validated['id_siswa'],
            'id_admin' => auth()->id(),
            'id_guru' => $validated['id_guru'] ?? auth()->id(),
            'kategori_perilaku_id' => $validated['kategori_perilaku_id'],
            'nilai' => $validated['nilai'],
            'tanggal' => $validated['tanggal'],
            'komentar' => $validated['komentar'],
        ]);

        $siswa->increment('poin', $kategori->poin);

        return redirect()->route('admin.daftar-siswa')->with('success', 'Perilaku siswa berhasil dicatat dan poin berhasil diperbarui.');
    }

    public function formTambahOrangTua()
    {
        $siswas = Siswa::with('user')->get(); // biar bisa akses nama siswa juga
        return view('admin.form-tambah-orang-tua', compact('siswas'));
    }
    

public function tambahOrangTua(Request $request)
{
    $validated = $request->validate([
        'username' => 'required|string|max:255|unique:users',
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
        'siswa_id' => 'nullable|exists:siswa,id',
    ]);

    $user = User::create([
        'username' => $validated['username'],
        'nama' => $validated['nama'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => 'orang_tua',
    ]);

    $orangTua = OrangTua::create([
        'id_user' => $user->id,
    ]);

    if ($request->filled('siswa_id')) {
        $siswa = Siswa::find($request->siswa_id);
        $siswa->orang_tua_id = $orangTua->id;
        $siswa->save();
    }

    return redirect()->route('admin.form-tambah-orang-tua')->with('success', 'Orang Tua berhasil ditambahkan dan dihubungkan ke siswa.');
}



}
