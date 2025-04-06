<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo dan Menu Utama -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <x-application-logo class="h-10 w-auto text-indigo-600" />
                    <span class="ml-2 text-xl font-semibold text-gray-800 hidden md:block">Monitoring Siswa</span>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex space-x-1">
                    @auth
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.kelola-pengguna') }}" class="{{ request()->routeIs('admin.kelola-pengguna') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Kelola Pengguna
                    </a>
                    <a href="{{ route('admin.kategori-perilaku.index') }}" class="{{ request()->routeIs('admin.kategori-perilaku.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Kategori
                    </a>
                    <a href="{{ route('admin.daftar-siswa') }}" class="{{ request()->routeIs('admin.daftar-siswa') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Siswa
                    </a>
                    @elseif(auth()->user()->role === 'guru')
                    <!-- Menu untuk guru -->
                    <a href="{{ route('guru.dashboard') }}" class="{{ request()->routeIs('guru.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('guru.daftar-siswa') }}" class="{{ request()->routeIs('guru.daftar-siswa') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Daftar Siswa
                    </a>
                    @elseif(auth()->user()->role === 'siswa')
                    <!-- Menu untuk siswa -->
                    <a href="{{ route('siswa.dashboard') }}" class="{{ request()->routeIs('siswa.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('siswa.semua-perilaku') }}" class="{{ request()->routeIs('siswa.semua-perilaku') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Catatan Perilaku
                    </a>
                    @elseif(auth()->user()->role === 'orang_tua')
                    <!-- Menu untuk orang tua -->
                    <a href="{{ route('orangtua.dashboard') }}" class="{{ request()->routeIs('orangtua.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('orangtua.semua-perilaku') }}" class="{{ request()->routeIs('orangtua.semua-perilaku') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Perilaku Siswa
                    </a>
                    @endif
                    @endauth
                </div>
            </div>

            <!-- Right Icons -->
            <div class="flex items-center space-x-4">
                <!-- Notif Icon -->
                <div class="relative">
                    <button id="notif-btn" class="p-1 text-gray-500 hover:text-gray-700 focus:outline-none relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span id="notif-badge" class="hidden absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                    </button>

                    <!-- Notifikasi Dropdown -->
                    <div id="notif-dropdown" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg overflow-hidden z-50 border border-gray-200">
                        <div class="py-1">
                            <div class="px-4 py-2 border-b border-gray-100 bg-gray-50 text-sm font-medium text-gray-700">
                                Notifikasi
                            </div>
                            <div id="notif-list" class="max-h-96 overflow-y-auto">
                                <!-- Notifikasi akan dimuat di sini -->
                                <div class="px-4 py-3 text-center text-sm text-gray-500">
                                    Memuat notifikasi...
                                </div>
                            </div>
                            <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Lihat Semua Notifikasi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User Dropdown -->
                <div class="relative">
                    <button id="user-menu-btn" class="flex items-center space-x-2 focus:outline-none">
                        <span class="hidden md:inline-block text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="-mr-2 flex items-center md:hidden">
                <button id="mobile-menu-btn" class="p-2 text-gray-500 hover:text-gray-600 focus:outline-none">
                    <svg id="mobile-menu-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="mobile-menu-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} block px-3 py-2 rounded-md text-base font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.kelola-pengguna') }}" class="{{ request()->routeIs('admin.kelola-pengguna') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} block px-3 py-2 rounded-md text-base font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Kelola Pengguna
            </a>
            <a href="{{ route('admin.kategori-perilaku.index') }}" class="{{ request()->routeIs('admin.kategori-perilaku.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} block px-3 py-2 rounded-md text-base font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Kategori
            </a>
            <a href="{{ route('admin.daftar-siswa') }}" class="{{ request()->routeIs('admin.daftar-siswa') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} block px-3 py-2 rounded-md text-base font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Siswa
            </a>
            @elseif(auth()->user()->role === 'guru')
            <!-- Menu mobile untuk guru -->
            <a href="{{ route('guru.dashboard') }}" class="{{ request()->routeIs('guru.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} block px-3 py-2 rounded-md text-base font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('guru.daftar-siswa') }}" class="{{ request()->routeIs('guru.daftar-siswa') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} block px-3 py-2 rounded-md text-base font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Daftar Siswa
            </a>
            @elseif(auth()->user()->role === 'siswa')
            <!-- Menu mobile untuk siswa -->
            <a href="{{ route('siswa.dashboard') }}" class="{{ request()->routeIs('siswa.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} block px-3 py-2 rounded-md text-base font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('siswa.semua-perilaku') }}" class="{{ request()->routeIs('siswa.semua-perilaku') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} block px-3 py-2 rounded-md text-base font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Catatan Perilaku
            </a>
            @elseif(auth()->user()->role === 'orang_tua')
            <!-- Menu mobile untuk orang tua -->
            <a href="{{ route('orangtua.dashboard') }}" class="{{ request()->routeIs('orangtua.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} block px-3 py-2 rounded-md text-base font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('orangtua.semua-perilaku') }}" class="{{ request()->routeIs('orangtua.semua-perilaku') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }} block px-3 py-2 rounded-md text-base font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Perilaku Siswa
            </a>
            @endif
            @endauth
        </div>

        <!-- User Info Mobile -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk toggle dropdown dengan penutupan saat klik di luar
        function setupDropdown(buttonId, dropdownId) {
            const button = document.getElementById(buttonId);
            const dropdown = document.getElementById(dropdownId);

            if (!button || !dropdown) return;

            button.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');

                // Tutup dropdown lainnya
                document.querySelectorAll('.dropdown-content').forEach(otherDropdown => {
                    if (otherDropdown.id !== dropdownId && !otherDropdown.classList.contains('hidden')) {
                        otherDropdown.classList.add('hidden');
                    }
                });
            });

            // Tutup dropdown saat klik di luar
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target) && e.target !== button) {
                    dropdown.classList.add('hidden');
                }
            });
        }

        // Tambahkan class dropdown-content ke semua dropdown
        document.getElementById('notif-dropdown').classList.add('dropdown-content');
        document.getElementById('user-dropdown').classList.add('dropdown-content');

        // Setup dropdown notifikasi dan user
        setupDropdown('notif-btn', 'notif-dropdown');
        setupDropdown('user-menu-btn', 'user-dropdown');

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuOpen = document.getElementById('mobile-menu-open');
        const mobileMenuClose = document.getElementById('mobile-menu-close');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                mobileMenuOpen.classList.toggle('hidden');
                mobileMenuClose.classList.toggle('hidden');
            });

            // Tutup mobile menu saat klik di luar
            document.addEventListener('click', function(e) {
                if (!mobileMenu.contains(e.target) && e.target !== mobileMenuBtn) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuOpen.classList.remove('hidden');
                    mobileMenuClose.classList.add('hidden');
                }
            });
        }

        // Update notifikasi badge (contoh)
        setTimeout(() => {
            const notifBadge = document.getElementById('notif-badge');
            if (notifBadge) {
                notifBadge.classList.remove('hidden');
                notifBadge.classList.add('animate-ping');
            }
        }, 1000);
    });
</script>

<style>
    /* Animasi untuk notifikasi badge */
    .animate-ping {
        animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    @keyframes ping {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        75%,
        100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }

    /* Transisi untuk dropdown */
    .dropdown-content {
        transition: all 0.2s ease-out;
    }

    /* Animasi untuk notifikasi baru */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bg-indigo-50 {
        animation: fadeIn 0.3s ease-out;
    }

    /* Badge notifikasi */
    .notification-badge {
        top: -0.5rem;
        right: -0.5rem;
        font-size: 0.75rem;
        height: 1.25rem;
        min-width: 1.25rem;
    }
</style>

<script>
    function loadInitialNotifications() {
        fetch('/api/notifications', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                const notifList = document.getElementById('notif-list');

                if (data.length > 0) {
                    notifList.innerHTML = '';

                    data.forEach(notification => {
                        const notifData = JSON.parse(notification.data);
                        const notificationElement = document.createElement('a');
                        notificationElement.href = notifData.action_url. {
                            {
                                auth() - > user() - > role
                            }
                        };
                        notificationElement.className = 'block px-4 py-3 hover:bg-gray-50 border-b border-gray-100';
                        notificationElement.innerHTML = `
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-900">${notifData.perilaku_kategori}</span>
                        <span class="text-xs text-gray-500">${new Date(notification.created_at).toLocaleTimeString()}</span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">
                        ${notifData.guru_nama} mencatat perilaku ${notifData.perilaku_kategori} (${notifData.poin_kategori > 0 ? '+' : ''}${notifData.poin_kategori} poin)
                    </p>
                `;

                        notifList.appendChild(notificationElement);
                    });
                } else {
                    notifList.innerHTML = `
                <div class="px-4 py-3 text-center text-sm text-gray-500">
                    Belum ada notifikasi
                </div>
            `;
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
            });
    }

    // Panggil saat halaman dimuat
    loadInitialNotifications();

    // Di dalam event listener DOMContentLoaded
    pusherChannel.bind('perilaku-baru', function(data) {
        showNotification(data);
        updatePoinSiswa(data.total_poin);

        // Jika berada di halaman notifikasi, refresh daftar
        if (window.location.pathname === '/notifications') {
            loadInitialNotifications();
        }
    });

    // Fungsi untuk memuat notifikasi dengan AJAX
    function loadInitialNotifications() {
        fetch('/notifications?ajax=1')
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.divide-y');

                if (newContent) {
                    document.querySelector('.divide-y').innerHTML = newContent.innerHTML;
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>