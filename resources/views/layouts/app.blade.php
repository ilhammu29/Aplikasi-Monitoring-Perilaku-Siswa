<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.3s ease-out forwards;
    }
    
    .animate-fade-out {
        animation: fadeOut 0.3s ease-out forwards;
    }
    
    /* Icon styles */
    .bi {
        display: inline-block;
        font-size: 1.2rem;
    }
</style>
<body class="bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
                <div id="notifikasi-area"></div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script>
    // Debug connection
    function debugPusher() {
        const pusher = window.Echo.connector.pusher;
        
        pusher.connection.bind('state_change', (states) => {
            console.log('Pusher state changed:', states.current);
        });
        
        pusher.connection.bind('error', (err) => {
            console.error('Pusher error:', err);
        });
        
        console.log('Pusher connection state:', pusher.connection.state);
        console.log('Subscribed channels:', pusher.channels.channels);
    }
    
    // Jalankan debug setelah Echo diinisialisasi
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(debugPusher, 1000);
    });
</script>
</body>
</html>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    // Inisialisasi Pusher
    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        encrypted: true
    });

    // Subscribe ke channel user
    @auth
        const channel = pusher.subscribe('user.{{ auth()->id() }}');
        
        // Listen untuk event perilaku baru
        channel.bind('perilaku.baru', function(data) {
            // Tambahkan notifikasi baru ke UI
            addNotificationToUI(data);
            
            // Update badge notifikasi
            updateNotificationBadge();
            
            // Play sound
            playNotificationSound();
        });
        
        function addNotificationToUI(data) {
            const notifList = document.getElementById('notifications-list');
            
            if (notifList) {
                // Hapus pesan "Tidak ada notifikasi" jika ada
                if (notifList.querySelector('.no-notifications')) {
                    notifList.innerHTML = '';
                }
                
                // Buat elemen notifikasi baru
                const notificationElement = document.createElement('li');
                notificationElement.className = 'notification-item bg-blue-50';
                notificationElement.innerHTML = `
                    <a href="${data.action_url}" class="block p-4 hover:bg-blue-100">
                        <div class="flex justify-between">
                            <p class="font-medium">${data.perilaku_kategori}</p>
                            <span class="text-xs text-gray-500">Baru saja</span>
                        </div>
                        <p class="text-sm mt-1">${data.guru_nama}: ${data.komentar}</p>
                    </a>
                `;
                
                // Tambahkan di paling atas
                notifList.insertBefore(notificationElement, notifList.firstChild);
            }
        }
        
        function updateNotificationBadge() {
            const badge = document.getElementById('notification-badge');
            if (badge) {
                const currentCount = parseInt(badge.textContent) || 0;
                badge.textContent = currentCount + 1;
                badge.classList.remove('hidden');
            }
        }
        
        function playNotificationSound() {
            const audio = new Audio('{{ asset('sounds/notification.mp3') }}');
            audio.play().catch(e => console.log('Autoplay prevented:', e));
        }
    @endauth
</script>
