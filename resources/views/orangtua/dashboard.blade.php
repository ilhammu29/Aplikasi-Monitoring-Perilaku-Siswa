<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Orang Tua') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Informasi Siswa -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Informasi Siswa</h3>
                        <span class="px-3 py-1 rounded-full text-sm font-medium 
                            {{ $siswa->poin >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            Total Poin: {{ $siswa->poin }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama Lengkap</p>
                            <p class="font-medium">{{ $siswa->user->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nomor Induk</p>
                            <p class="font-medium">{{ $siswa->nomor_induk }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kelas</p>
                            <p class="font-medium">{{ $siswa->kelas }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan Periodik -->
            @if($laporanPeriodik->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium mb-4">Laporan Periodik</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rata-rata Nilai</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($laporanPeriodik as $laporan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $laporan->periode }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($laporan->rata_nilai, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                                    {{ $laporan->status == 'baik' ? 'bg-green-100 text-green-800' : 
                                                       ($laporan->status == 'cukup' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($laporan->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Catatan Perilaku Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Catatan Perilaku Terbaru</h3>
                        @if($perilakuTerbaru->count() > 0)
                        <a href="{{ route('orangtua.semua-perilaku') }}" class="text-sm text-blue-500 hover:text-blue-700">
                            Lihat Semua →
                        </a>
                        @endif
                    </div>

                    @if($perilakuTerbaru->count() > 0)
                    <div class="space-y-4">
                        @foreach($perilakuTerbaru as $perilaku)
                        <div class="border-l-4 {{ $perilaku->kategori->poin >= 0 ? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50' }} p-4 rounded">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium">{{ $perilaku->kategori->nama }}</p>
                                    <p class="text-sm text-gray-600">
                                        @if($perilaku->tanggal instanceof \Carbon\Carbon)
                                        {{ $perilaku->tanggal->format('d F Y') }}
                                        @else
                                        {{ \Carbon\Carbon::parse($perilaku->tanggal)->format('d F Y') }}
                                        @endif
                                    </p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full font-bold 
                {{ $perilaku->kategori->poin >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $perilaku->kategori->poin >= 0 ? '+' : '' }}{{ $perilaku->kategori->poin }} Poin
                                </span>
                            </div>
                            @if($perilaku->komentar)
                            <p class="mt-2 text-sm text-gray-700">"{{ $perilaku->komentar }}"</p>
                            @endif
                            <p class="mt-1 text-sm text-gray-500">Oleh: {{ $perilaku->guru->user->nama ?? 'Admin' }}</p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500">Belum ada catatan perilaku.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>