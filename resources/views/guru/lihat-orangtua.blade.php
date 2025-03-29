<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Orang Tua Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Data Siswa</h3>
                        <p><span class="font-medium">Nama:</span> {{ $siswa->user->nama }}</p>
                        <p><span class="font-medium">NIS:</span> {{ $siswa->nomor_induk }}</p>
                        <p><span class="font-medium">Kelas:</span> {{ $siswa->kelas }}</p>
                        <p><span class="font-medium">Jurusan:</span> {{ $siswa->jurusan }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium mb-2">Data Orang Tua</h3>
                        @if($siswa->orangTua)
                            <p><span class="font-medium">Nama:</span> {{ $siswa->orangTua->user->nama }}</p>
                            <p><span class="font-medium">Username:</span> {{ $siswa->orangTua->user->username }}</p>
                            <p><span class="font-medium">Email:</span> {{ $siswa->orangTua->user->email }}</p>
                        @else
                            <p class="text-gray-500">Data orang tua belum tersedia</p>
                        @endif
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('guru.daftar-siswa') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Kembali ke Daftar Siswa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>