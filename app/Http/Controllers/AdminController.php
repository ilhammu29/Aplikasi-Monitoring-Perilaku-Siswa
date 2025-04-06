<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
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
            'role' => 'required|in:admin,guru,siswa,orang_tua',
        ]);

        // Validasi tambahan hanya untuk siswa
        if ($request->role === 'siswa') {
            $siswaData = $request->validate([
                'nomor_induk' => 'required|unique:siswa,nomor_induk',
                'kelas' => 'required|string|max:50',
                'jurusan' => 'required|string|max:100',
            ]);
        }

        // Simpan user
        $user = User::create([
            'username' => $validated['username'],
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);

        // Simpan data siswa jika role-nya siswa
        if ($user->role === 'siswa') {
            Siswa::create([
                'id_user' => $user->id,
                'nomor_induk' => $siswaData['nomor_induk'],
                'kelas' => $siswaData['kelas'],
                'jurusan' => $siswaData['jurusan'],
                'poin' => 100,
            ]);
        }

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
        event(new \App\Events\PenggunaBaruDitambahkan($user->nama, $user->role));

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

        // Handle masing-masing role
        switch ($request->role) {
            case 'siswa':
                $request->validate([
                    'nomor_induk' => [
                        'required',
                        Rule::unique('siswa', 'nomor_induk')->ignore($user->id, 'id_user'),
                    ],
                    'kelas' => 'required|string|max:50',
                    'jurusan' => 'required|string|max:100',
                ]);

                if (!$user->siswa) {
                    $user->siswa()->create([
                        'nomor_induk' => $request->nomor_induk,
                        'kelas' => $request->kelas,
                        'jurusan' => $request->jurusan,
                        'poin' => 100,
                    ]);
                } else {
                    $user->siswa->update([
                        'nomor_induk' => $request->nomor_induk,
                        'kelas' => $request->kelas,
                        'jurusan' => $request->jurusan,
                    ]);
                }

                // Hapus data guru/ortu jika ada
                $user->guru()?->delete();
                $user->orangTua()?->delete();
                break;

            case 'guru':
                $request->validate([
                    'nip' => [
                        'required',
                        Rule::unique('guru', 'nip')->ignore($user->id, 'id_user'),
                    ],
                ]);

                if (!$user->guru) {
                    $user->guru()->create([
                        'nip' => $request->nip,
                    ]);
                } else {
                    $user->guru->update([
                        'nip' => $request->nip,
                    ]);
                }

                $user->siswa()?->delete();
                $user->orangTua()?->delete();
                break;

            case 'orang_tua':
                $request->validate([
                    'id_siswa' => 'required|exists:siswa,id',
                ]);

                if (!$user->orangTua) {
                    $user->orangTua()->create([
                        'id_siswa' => $request->id_siswa,
                    ]);
                } else {
                    $user->orangTua->update([
                        'id_siswa' => $request->id_siswa,
                    ]);
                }

                $user->siswa()?->delete();
                $user->guru()?->delete();
                break;

            default:
                // Kalau admin, hapus semua relasi khusus
                $user->siswa()?->delete();
                $user->guru()?->delete();
                $user->orangTua()?->delete();
                break;
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
        'id_guru' => 'nullable|exists:guru,id_guru',
    ]);

    DB::beginTransaction();

    try {
        $kategori = KategoriPerilaku::findOrFail($validated['kategori_perilaku_id']);
        $siswa = Siswa::findOrFail($validated['id_siswa']);
        $guru = $validated['id_guru'] ? Guru::findOrFail($validated['id_guru']) : null;

        $perilaku = Perilaku::create([
            'id_siswa' => $validated['id_siswa'],
            'id_guru' => $guru ? $guru->id_guru : null,
            'kategori_perilaku_id' => $validated['kategori_perilaku_id'],
            'nilai' => $validated['nilai'],
            'tanggal' => $validated['tanggal'],
            'komentar' => $validated['komentar'],
        ]);

        // Update poin siswa
        $siswa->increment('poin', $kategori->poin);

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
            'guru_nama' => $guru ? $guru->user->nama : 'Admin',
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
            ->route('admin.daftar-siswa')
            ->with('success', 'Perilaku siswa berhasil dicatat dan notifikasi telah dikirim.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Gagal menyimpan perilaku: ' . $e->getMessage());

        return back()
            ->withInput()
            ->with('error', 'Gagal menyimpan data perilaku: ' . $e->getMessage());
    }
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
