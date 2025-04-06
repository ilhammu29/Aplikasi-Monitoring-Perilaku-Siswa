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