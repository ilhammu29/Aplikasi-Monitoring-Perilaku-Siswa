<?php

// app/Notifications/NotifikasiPerilakuBaru.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NotifikasiPerilakuBaru extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    // 🔔 Simpan di database
    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'title' => 'Perilaku Baru Ditambahkan',
            'body' => "{$this->data['nama_guru']} mencatat perilaku: {$this->data['kategori']} untuk kamu dengan nilai {$this->data['nilai']}",
            'data' => $this->data
        ]);
    }

    // 🚀 Dikirim realtime via broadcast juga
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'Perilaku Baru Ditambahkan',
            'body' => "{$this->data['nama_guru']} mencatat perilaku: {$this->data['kategori']} untuk kamu dengan nilai {$this->data['nilai']}",
            'data' => $this->data
        ]);
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }
}

