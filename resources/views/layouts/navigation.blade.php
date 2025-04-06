<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center space-x-6">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="h-10 w-auto text-gray-700" />
                </a>

                <!-- Desktop Nav -->
                <div class="hidden sm:flex space-x-4">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Dashboard Admin</x-nav-link>
                            <x-nav-link :href="route('admin.kelola-pengguna')" :active="request()->routeIs('admin.kelola-pengguna')">Kelola Pengguna</x-nav-link>
                            <x-nav-link :href="route('admin.kategori-perilaku.index')" :active="request()->routeIs('admin.kategori-perilaku.*')">Kategori Perilaku</x-nav-link>
                            <x-nav-link :href="route('admin.daftar-siswa')" :active="request()->routeIs('admin.daftar-siswa')">Daftar Siswa</x-nav-link>
                            <x-nav-link :href="route('admin.form-tambah-orang-tua')" :active="request()->routeIs('admin.daftar-siswa')">Koneksi Orang</x-nav-link>
                        @elseif(auth()->user()->role === 'guru')
                            <x-nav-link :href="route('guru.dashboard')" :active="request()->routeIs('guru.dashboard')">Dashboard Guru</x-nav-link>
                            <x-nav-link :href="route('guru.daftar-siswa')" :active="request()->routeIs('guru.daftar-siswa')">Daftar Siswa</x-nav-link>
                        @elseif(auth()->user()->role === 'siswa')
                            <x-nav-link :href="route('siswa.dashboard')" :active="request()->routeIs('siswa.dashboard')">Dashboard Siswa</x-nav-link>
                        @elseif(auth()->user()->role === 'orang_tua')
                            <x-nav-link :href="route('orangtua.dashboard')" :active="request()->routeIs('orangtua.dashboard')">Dashboard Orang Tua</x-nav-link>
                            <x-nav-link :href="route('orangtua.semua-perilaku')" :active="request()->routeIs('orangtua.semua-perilaku')">Perilaku Siswa</x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Icons -->
            <div class="flex items-center space-x-4">
                <!-- Notif Icon -->
                <div class="relative">
                    <button id="notif-icon" class="relative text-gray-600 hover:text-gray-800 transition">
                        <i class="bi bi-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                    </button>
                    <ul id="notif-list" class="absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-50 text-sm max-h-60 overflow-auto">
                        <li class="px-4 py-2 text-gray-700 hover:bg-gray-100">Belum ada notifikasi.</li>
                    </ul>
                </div>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-600 hover:text-gray-800 focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger for Mobile -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Nav -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Dashboard Admin</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.kelola-pengguna')" :active="request()->routeIs('admin.kelola-pengguna')">Kelola Pengguna</x-responsive-nav-link>
                @elseif(auth()->user()->role === 'guru')
                    <x-responsive-nav-link :href="route('guru.dashboard')" :active="request()->routeIs('guru.dashboard')">Dashboard Guru</x-responsive-nav-link>
                @elseif(auth()->user()->role === 'siswa')
                    <x-responsive-nav-link :href="route('siswa.dashboard')" :active="request()->routeIs('siswa.dashboard')">Dashboard Siswa</x-responsive-nav-link>
                @elseif(auth()->user()->role === 'orang_tua')
                    <x-responsive-nav-link :href="route('orangtua.dashboard')" :active="request()->routeIs('orangtua.dashboard')">Dashboard Orang Tua</x-responsive-nav-link>
                @endif
            @endauth
        </div>
    </div>
</nav>
<script>
    document.getElementById('notif-icon')?.addEventListener('click', function () {
        document.getElementById('notif-list')?.classList.toggle('hidden');
    });
</script>
