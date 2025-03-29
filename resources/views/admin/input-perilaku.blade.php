<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Perilaku Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Informasi Siswa -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium mb-2">Informasi Siswa</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Nama</p>
                                <p class="font-medium">{{ $siswa->user->nama }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">NIS</p>
                                <p class="font-medium">{{ $siswa->nomor_induk }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Kelas</p>
                                <p class="font-medium">{{ $siswa->kelas }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jurusan</p>
                                <p class="font-medium">{{ $siswa->jurusan }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Poin Saat Ini</p>
                                <p class="text-lg font-bold {{ $siswa->poin >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $siswa->poin }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Input Perilaku -->
                    <form method="POST" action="{{ route('admin.store-perilaku') }}">
                        @csrf
                        <input type="hidden" name="id_siswa" value="{{ $siswa->id_siswa }}">

                        <div class="mb-4">
                            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal *</label>
                            <input type="date" name="tanggal" id="tanggal" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                value="{{ old('tanggal', now()->format('Y-m-d')) }}">
                            @error('tanggal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kategori_perilaku_id" class="block text-sm font-medium text-gray-700">Kategori Perilaku *</label>
                            <select name="kategori_perilaku_id" id="kategori_perilaku_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoriPerilaku as $kategori)
                                <option value="{{ $kategori->id }}" data-poin="{{ $kategori->poin }}"
                                    {{ old('kategori_perilaku_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }} ({{ $kategori->poin >= 0 ? '+' : '' }}{{ $kategori->poin }})
                                </option>
                                @endforeach
                            </select>
                            @error('kategori_perilaku_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="komentar" class="block text-sm font-medium text-gray-700">Komentar (Opsional)</label>
                            <textarea name="komentar" id="komentar" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Masukkan catatan tambahan tentang perilaku siswa">{{ old('komentar') }}</textarea>
                            @error('komentar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nilai" class="block text-sm font-medium text-gray-700">Nilai Perilaku *</label>
                            <input type="number" name="nilai" id="nilai" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                min="1" max="100"
                                value="{{ old('nilai') }}">
                            @error('nilai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preview Perubahan Poin -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg hidden" id="poin-preview">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Perubahan Poin</h4>
                            <p class="text-sm">Poin saat ini: <span class="font-bold">{{ $siswa->poin }}</span></p>
                            <p class="text-sm">Perubahan: <span id="poin-change" class="font-bold"></span></p>
                            <p class="text-sm">Poin setelah perubahan: <span id="poin-after" class="font-bold"></span></p>
                        </div>

                        

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.daftar-siswa') }}"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150">
                                Kembali
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-150">
                                Simpan Perilaku
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Menampilkan preview perubahan poin
        document.getElementById('kategori_perilaku_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const poinChange = parseInt(selectedOption.getAttribute('data-poin'));
            const currentPoin = parseInt({
                {
                    $siswa - > poin
                }
            });
            const newPoin = currentPoin + poinChange;

            if (selectedOption.value) {
                const poinPreview = document.getElementById('poin-preview');
                document.getElementById('poin-change').textContent = (poinChange >= 0 ? '+' : '') + poinChange;
                document.getElementById('poin-after').textContent = newPoin;

                // Update warna berdasarkan perubahan
                const changeElement = document.getElementById('poin-change');
                const afterElement = document.getElementById('poin-after');

                changeElement.className = poinChange >= 0 ? 'font-bold text-green-600' : 'font-bold text-red-600';
                afterElement.className = newPoin >= 0 ? 'font-bold text-green-600' : 'font-bold text-red-600';

                poinPreview.classList.remove('hidden');
            } else {
                document.getElementById('poin-preview').classList.add('hidden');
            }
        });

        // Inisialisasi preview jika ada nilai yang sudah dipilih (ketika validasi error)
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.getElementById('kategori_perilaku_id');
            if (selectElement.value) {
                selectElement.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout>