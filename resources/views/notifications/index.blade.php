<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notifikasi
            </h2>
            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                @csrf
                <x-primary-button type="submit" class="text-sm">
                    Tandai Semua Dibaca
                </x-primary-button>
            </form>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            @if($notifications->isEmpty())
                <div class="p-6 text-center text-gray-500">
                    Tidak ada notifikasi
                </div>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($notifications as $notification)
                        @php
                            $data = json_decode($notification->data, true);
                            $isUnread = is_null($notification->read_at);
                        @endphp
                        
                        <li class="{{ $isUnread ? 'bg-indigo-50' : 'bg-white' }}">
                            <a href="{{ $data['action_url'][auth()->user()->role] ?? '#' }}" 
                               class="block hover:bg-gray-50 px-4 py-4 sm:px-6"
                               onclick="event.preventDefault(); document.getElementById('mark-read-form-{{ $notification->id }}').submit();">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center min-w-0">
                                        <div class="ml-3 min-w-0 flex-1">
                                            <p class="text-sm font-medium {{ $isUnread ? 'text-indigo-800' : 'text-gray-900' }} truncate">
                                                {{ $data['perilaku_kategori'] }} - {{ $data['poin_kategori'] > 0 ? '+' : '' }}{{ $data['poin_kategori'] }} poin
                                            </p>
                                            <p class="text-sm text-gray-500 truncate mt-1">
                                                {{ $data['guru_nama'] }} - {{ $data['komentar'] }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-2">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    @if($isUnread)
                                        <span class="ml-2 flex-shrink-0 inline-block px-2 py-0.5 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">
                                            Baru
                                        </span>
                                    @endif
                                </div>
                            </a>
                            
                            <form id="mark-read-form-{{ $notification->id }}" 
                                  action="{{ route('notifications.mark-read', $notification) }}" 
                                  method="POST" 
                                  class="hidden">
                                @csrf
                            </form>
                        </li>
                    @endforeach
                </ul>
                
                <div class="px-4 py-3 bg-gray-50 sm:px-6">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>