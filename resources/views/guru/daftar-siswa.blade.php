<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jurusan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($siswas as $siswa)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->nomor_induk }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->user->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->kelas }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->jurusan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                           <!-- resources/views/guru/daftar-siswa.blade.php -->
<a href="{{ route('guru.show-input-perilaku', $siswa->id_siswa) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Input Perilaku</a>
                                            <a href="{{ route('guru.lihat-orangtua', $siswa->id_siswa) }}" class="text-blue-600 hover:text-blue-900">Lihat Orang Tua</a>
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
</x-app-layout>