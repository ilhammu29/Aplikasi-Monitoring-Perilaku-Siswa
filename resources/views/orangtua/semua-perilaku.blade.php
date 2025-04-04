<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Semua Catatan Perilaku') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                        <h3 class="text-lg font-medium">
    Catatan Perilaku {{ $siswa?->user?->nama ?? 'Nama Siswa Tidak Diketahui' }}
</h3>

<p class="text-sm text-gray-500">Total Poin: {{ $siswa?->poin ?? 0 }}</p>

                        </div>
                        <a href="{{ route('orangtua.dashboard') }}" class="text-blue-500 hover:text-blue-700">
                            Kembali ke Dashboard
                        </a>
                    </div>

                    @if($semuaPerilaku->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poin</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Oleh</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komentar</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($semuaPerilaku as $perilaku)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $perilaku->tanggal->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $perilaku->kategori->nama ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    {{ ($perilaku->kategori->poin ?? 0) >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ($perilaku->kategori->poin >= 0 ? '+' : '') . ($perilaku->kategori->poin ?? 0) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $perilaku->guru?->user?->nama ?? 'Admin' }}
                                            </td>
                                            <td class="px-6 py-4">{{ $perilaku->komentar ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $semuaPerilaku->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada catatan perilaku.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
