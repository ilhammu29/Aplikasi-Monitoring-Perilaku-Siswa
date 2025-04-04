<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-medium">Daftar Pengguna</h3>
                        <button onclick="document.getElementById('tambahPenggunaModal').showModal()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Tambah Pengguna
                        </button>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 text-xs font-medium text-gray-500 uppercase">
                                <tr>
                                    <th class="px-6 py-3 text-left">Nama</th>
                                    <th class="px-6 py-3 text-left">Username</th>
                                    <th class="px-6 py-3 text-left">Email</th>
                                    <th class="px-6 py-3 text-left">Role</th>
                                    <th class="px-6 py-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                    <tr>
                                        <td class="px-6 py-4">{{ $user->nama }}</td>
                                        <td class="px-6 py-4">{{ $user->username }}</td>
                                        <td class="px-6 py-4">{{ $user->email }}</td>
                                        <td class="px-6 py-4">{{ ucfirst($user->role) }}</td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <button onclick="openEditModal('{{ $user->id }}', '{{ $user->nama }}', '{{ $user->username }}', '{{ $user->email }}', '{{ $user->role }}')" class="text-indigo-600 hover:text-indigo-900">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.hapus-pengguna', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pengguna -->
    <dialog id="tambahPenggunaModal" class="rounded-lg shadow-xl p-6 w-full max-w-md backdrop:bg-black/30 backdrop:backdrop-blur-sm">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Tambah Pengguna Baru</h3>
            <button onclick="document.getElementById('tambahPenggunaModal').close()" class="text-gray-500 hover:text-gray-700 text-xl">
                &times;
            </button>
        </div>
        <form method="POST" action="{{ route('admin.tambah-pengguna') }}">
    @csrf
    <div class="mb-4">
        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" name="nama" id="nama" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>
    <div class="mb-4">
        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" name="username" id="username" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>

    <!-- Siswa Fields (Hidden by default) -->
    <div id="siswaFields" class="hidden">
        <div class="mb-4">
            <label for="nomor_induk" class="block text-sm font-medium text-gray-700">NIS</label>
            <input type="text" name="nomor_induk" id="nomor_induk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div class="mb-4">
            <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
            <input type="text" name="kelas" id="kelas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div class="mb-4">
            <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
            <input type="text" name="jurusan" id="jurusan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" name="password" id="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>

    <div class="mb-4">
        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
        <select name="role" id="role" required onchange="toggleSiswaFields(this.value)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="admin">Admin</option>
            <option value="guru">Guru</option>
            <option value="siswa">Siswa</option>
            <option value="orang_tua">Orang Tua</option>
        </select>
    </div>

    <div class="flex justify-end">
        <button type="button" onclick="document.getElementById('tambahPenggunaModal').close()" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
            Batal
        </button>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            Simpan
        </button>
    </div>
</form>

    </dialog>
    <!-- Modal Edit Pengguna -->
    <dialog id="editPenggunaModal" class="rounded-lg shadow-xl p-6 w-full max-w-md backdrop:bg-black/30 backdrop:backdrop-blur-sm">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium">Edit Pengguna</h3>
        <button onclick="document.getElementById('editPenggunaModal').close()" class="text-gray-500 hover:text-gray-700 text-xl">
            &times;
        </button>
    </div>
    <form method="POST" id="editForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="edit_id">
        <div class="mb-4">
            <label for="edit_nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="nama" id="edit_nama" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div class="mb-4">
            <label for="edit_username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" name="username" id="edit_username" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div class="mb-4">
            <label for="edit_email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="edit_email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div class="mb-4">
            <label for="edit_role" class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" id="edit_role" onchange="toggleEditSiswaFields(this.value)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="admin">Admin</option>
                <option value="guru">Guru</option>
                <option value="siswa">Siswa</option>
                <option value="orang_tua">Orang Tua</option>
            </select>
        </div>

        <!-- Siswa Fields -->
        <div id="editSiswaFields" class="hidden">
            <div class="mb-4">
                <label for="edit_nomor_induk" class="block text-sm font-medium text-gray-700">NIS</label>
                <input type="text" name="nomor_induk" id="edit_nomor_induk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="mb-4">
                <label for="edit_kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                <input type="text" name="kelas" id="edit_kelas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="mb-4">
                <label for="edit_jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
                <input type="text" name="jurusan" id="edit_jurusan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
        </div>

        <div class="flex justify-end">
            <button type="button" onclick="document.getElementById('editPenggunaModal').close()" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Batal</button>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
        </div>
    </form>
</dialog>


</x-app-layout>
<script>
    function toggleSiswaFields(role) {
        const siswaFields = document.getElementById('siswaFields');
        siswaFields.classList.toggle('hidden', role !== 'siswa');
    }

    function toggleEditSiswaFields(role) {
        const siswaFields = document.getElementById('editSiswaFields');
        siswaFields.classList.toggle('hidden', role !== 'siswa');
    }

    function openEditModal(id, nama, username, email, role, nomor_induk = '', kelas = '', jurusan = '') {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;
        document.getElementById('edit_nomor_induk').value = nomor_induk;
        document.getElementById('edit_kelas').value = kelas;
        document.getElementById('edit_jurusan').value = jurusan;

        toggleEditSiswaFields(role);

        const form = document.getElementById('editForm');
        form.action = `/admin/pengguna/${id}`; // ganti dengan route sesuai backend kamu

        document.getElementById('editPenggunaModal').showModal();
    }
</script>

