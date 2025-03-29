<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        <div class="flex items-center justify-center text-red-500">
            <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div class="mt-4 text-center">
            <h3 class="text-lg font-medium text-gray-900">{{ $errors->first() }}</h3>
            <p class="mt-2">Silakan hubungi administrator untuk bantuan.</p>
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700">
                Kembali ke halaman login
            </a>
        </div>
    </div>
</x-guest-layout>