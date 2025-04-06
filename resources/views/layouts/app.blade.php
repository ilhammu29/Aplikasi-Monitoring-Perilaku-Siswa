<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
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
</body>
</html>

<script type="module" src="{{ asset('js/notifikasi.js') }}"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    // Aktifkan Pusher
    Pusher.logToConsole = true;
    var pusher = new Pusher('bae5951cdc1b37367717   ', {
        cluster: 'ap1',
        encrypted: true
    });

    var channel = pusher.subscribe('perilaku-channel');
    channel.bind('App\\Events\\PerilakuBaruDitambahkan', function(data) {
        const icon = document.getElementById("notif-icon");
        const list = document.getElementById("notif-list");

        icon.classList.add("text-red-600"); // Warna merah biar dramatis

        const item = document.createElement("li");
        item.innerText = `Perilaku baru dicatat: ${data.siswa} (${data.kategori})`;
        list.prepend(item);
    });
</script>
