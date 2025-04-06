// Fungsi untuk menambahkan perilaku baru ke dashboard
function addNewPerilakuToDashboard(data) {
    const perilakuContainer = document.getElementById('perilaku-container');
    const emptyMessage = document.querySelector('#perilaku-container p.text-gray-500');
    
    // Hapus pesan "Belum ada catatan perilaku" jika ada
    if (emptyMessage) {
        emptyMessage.remove();
    }
    
    // Buat elemen perilaku baru
    const newPerilaku = document.createElement('div');
    newPerilaku.className = `border-l-4 ${data.poin_kategori >= 0 ? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50'} p-4 rounded new-perilaku-item`;
    newPerilaku.innerHTML = `
        <div class="flex justify-between items-start">
            <div>
                <p class="font-medium">${data.perilaku_kategori}</p>
                <p class="text-sm text-gray-600">${formatTanggal(data.tanggal)}</p>
            </div>
            <span class="px-2 py-1 text-xs rounded-full font-bold 
                ${data.poin_kategori >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                ${data.nilai} (${data.poin_kategori >= 0 ? '+' : ''}${data.poin_kategori} Poin)
            </span>
        </div>
        ${data.komentar ? `<p class="mt-2 text-sm text-gray-700">"${data.komentar}"</p>` : ''}
        <p class="mt-1 text-sm text-gray-500">Oleh: ${data.guru_nama}</p>
    `;
    
    // Tambahkan ke awal container
    perilakuContainer.insertBefore(newPerilaku, perilakuContainer.firstChild);
    
    // Hapus item terakhir jika lebih dari 5
    if (perilakuContainer.children.length > 5) {
        perilakuContainer.removeChild(perilakuContainer.lastChild);
    }
    
    // Update total poin
    updateTotalPoin(data.total_poin);
    
    // Update link "Lihat Semua" jika belum ada
    const lihatSemuaLink = document.querySelector('#perilaku-container a[href*="semua-perilaku"]');
    if (!lihatSemuaLink && perilakuContainer.children.length > 0) {
        const headerDiv = document.querySelector('#perilaku-container').previousElementSibling;
        if (headerDiv) {
            const newLink = document.createElement('a');
            newLink.href = data.action_url.siswa;
            newLink.className = 'text-sm text-blue-500 hover:text-blue-700';
            newLink.textContent = 'Lihat Semua →';
            headerDiv.appendChild(newLink);
        }
    }
}

// Fungsi untuk memformat tanggal
function formatTanggal(tanggalString) {
    const options = { day: 'numeric', month: 'long', year: 'numeric' };
    return new Date(tanggalString).toLocaleDateString('id-ID', options);
}

// Update listener notifikasi siswa
@if(auth()->user()->role === 'siswa')
window.Echo.private(`siswa.{{ auth()->id() }}`)
    .listen('.perilaku-baru', (data) => {
        const notificationData = data.data;
        
        // Tampilkan notifikasi toast
        showToastNotification(
            `Anda mendapatkan catatan perilaku: ${notificationData.perilaku_kategori} (${notificationData.poin_kategori >= 0 ? '+' : ''}${notificationData.poin_kategori} poin)`, 
            'bg-yellow-100 border-yellow-500',
            notificationData.action_url.siswa
        );
        
        // Update dashboard jika di halaman dashboard
        if (window.location.pathname.includes('dashboard')) {
            addNewPerilakuToDashboard(notificationData);
        }
        
        // Update tabel jika di halaman semua-perilaku
        if (window.location.pathname.includes('semua-perilaku')) {
            addNewPerilakuToTable(notificationData);
        }
    });
@endif

function showToastNotification(message, bgClass, url = null) {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 p-4 rounded-lg border-l-4 shadow-lg ${bgClass} text-gray-800 max-w-xs z-50 transition-all duration-300 transform translate-y-0 opacity-100`;
    
    if (url) {
        toast.onclick = () => {
            window.location.href = url;
        };
        toast.classList.add('cursor-pointer');
    }
    
    toast.innerHTML = `
        <p class="font-medium">Notifikasi Baru</p>
        <p class="text-sm mt-1">${message}</p>
        <p class="text-xs text-gray-500 mt-2">${new Date().toLocaleTimeString()}</p>
    `;
    
    document.body.appendChild(toast);
    
    // Hilangkan toast setelah 5 detik
    setTimeout(() => {
        toast.classList.add('translate-y-4', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}