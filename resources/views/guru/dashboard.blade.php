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
                    <h3 class="text-lg font-medium mb-4">Informasi Siswa</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama Siswa</p>
                            <p class="font-medium">{{ $siswa->user->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">NIS</p>
                            <p class="font-medium">{{ $siswa->nomor_induk }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Poin</p>
                            <p class="text-xl font-bold {{ $totalPoin >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $totalPoin }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Perkembangan Poin -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium mb-4">Perkembangan Poin</h3>
                    <canvas id="poinChart" height="150"></canvas>
                </div>
            </div>

            <!-- Daftar Perilaku Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Catatan Perilaku Terbaru</h3>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse ($perilaku->take(5) as $item)
                            <div class="border-l-4 {{ $item->kategori->poin >= 0 ? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50' }} p-4 rounded">
                                <div class="flex justify-between">
                                    <div>
                                        <p class="font-medium">{{ $item->kategori->nama }}</p>
                                        <p class="text-sm text-gray-600">{{ $item->tanggal->format('d F Y') }}</p>
                                    </div>
                                    <span class="font-bold {{ $item->kategori->poin >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $item->kategori->poin >= 0 ? '+' : '' }}{{ $item->kategori->poin }}
                                    </span>
                                </div>
                                @if($item->komentar)
                                    <p class="mt-2 text-sm text-gray-700">"{{ $item->komentar }}"</p>
                                @endif
                                <p class="mt-1 text-sm">Oleh: {{ $item->guru->user->nama ?? 'Admin' }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada catatan perilaku.</p>
                        @endforelse
                    </div>

                    @if($perilaku->count() > 5)
                        <div class="mt-4 text-center">
                            <a href="{{ route('orangtua.perilaku') }}" class="text-blue-500 hover:text-blue-700">
                                Lihat Semua Catatan Perilaku →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('poinChart').getContext('2d');
                const labels = @json($perkembanganPoin->map(fn($item) => `${$item->tahun}-${String($item->bulan).padStart(2, '0')}`));
                const data = @json($perkembanganPoin->pluck('total_poin'));

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Perkembangan Poin',
                            data: data,
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>