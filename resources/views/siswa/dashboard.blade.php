@php
    use Carbon\Carbon;
    use Illuminate\Support\Str;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Informasi Siswa -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium">Informasi Siswa</h3>
                            <p class="text-sm text-gray-500 mt-1">Total Poin: 
                                <span class="font-bold {{ $siswa->poin >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $siswa->poin }}
                                </span>
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Kelas</p>
                                <p class="font-medium">{{ $siswa->kelas }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jurusan</p>
                                <p class="font-medium">{{ $siswa->jurusan }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Catatan Perilaku Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Catatan Perilaku Terbaru</h3>
                        @if(!$perilaku->isEmpty())
                            <a href="{{ route('siswa.semua-perilaku') }}" class="text-sm text-blue-500 hover:text-blue-700">
                                Lihat Semua →
                            </a>
                        @endif
                    </div>
                    
                    @if($perilaku->isEmpty())
                        <p class="text-gray-500">Belum ada catatan perilaku</p>
                    @else
                        <div class="space-y-4">
                            @foreach($perilaku as $p)
                                <div class="border-l-4 {{ $p->kategori->poin >= 0 ? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50' }} p-4 rounded">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium">{{ $p->kategori->nama }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($p->tanggal)->format('d F Y') }}
                                            </p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full font-bold 
                                            {{ $p->kategori->poin >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $p->nilai }} ({{ $p->kategori->poin >= 0 ? '+' : '' }}{{ $p->kategori->poin }} Poin)
                                        </span>
                                    </div>
                                    @if($p->komentar)
                                        <p class="mt-2 text-sm text-gray-700">"{{ $p->komentar }}"</p>
                                    @endif
                                    <p class="mt-1 text-sm text-gray-500">Oleh: {{ $p->guru->user->nama ?? 'Admin' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Laporan Perilaku -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium mb-4">Laporan Perilaku</h3>
                    
                    @if($laporan->isEmpty())
                        <p class="text-gray-500">Belum ada laporan perilaku</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rata-rata Nilai</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komentar Anda</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($laporan as $l)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $l->periode }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($l->rata_nilai, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($l->status === 'baik')
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Baik</span>
                                                @elseif($l->status === 'cukup')
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Cukup</span>
                                                @else
                                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Perlu Perbaikan</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $l->komentar_siswa ? Str::limit($l->komentar_siswa, 30) : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <button onclick="document.getElementById('komentarModal{{ $l->id_laporan }}').showModal()" 
                                                        class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                    {{ $l->komentar_siswa ? 'Edit' : 'Beri' }} Komentar
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Komentar Modal -->
                                        <dialog id="komentarModal{{ $l->id_laporan }}" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                                            <form method="POST" action="{{ route('siswa.beri-komentar', $l->id_laporan) }}">
                                                @csrf
                                                <div class="flex justify-between items-center mb-4">
                                                    <h3 class="text-lg font-medium">Komentar untuk Laporan {{ $l->periode }}</h3>
                                                    <button type="button" onclick="document.getElementById('komentarModal{{ $l->id_laporan }}').close()" 
                                                            class="text-gray-500 hover:text-gray-700 text-xl">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="komentar" class="block text-sm font-medium text-gray-700 mb-1">Komentar Anda</label>
                                                    <textarea name="komentar" id="komentar" rows="4"
                                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                              placeholder="Tulis komentar Anda tentang laporan ini">{{ old('komentar', $l->komentar_siswa) }}</textarea>
                                                    @error('komentar')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="flex justify-end space-x-3">
                                                    <button type="button" onclick="document.getElementById('komentarModal{{ $l->id_laporan }}').close()" 
                                                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                                        Simpan Komentar
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>