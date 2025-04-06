window.Echo.channel('perilaku-channel')
    .listen('.perilaku-baru', (e) => {
        const icon = document.getElementById('notif-icon');
        const list = document.getElementById('notif-list');
        icon.classList.add('text-danger'); // kasih efek merah

        const item = `<li>${e.data.siswa} → ${e.data.kategori} (${e.data.poin}) oleh ${e.data.guru}</li>`;
        list.innerHTML = item + list.innerHTML;
    });
