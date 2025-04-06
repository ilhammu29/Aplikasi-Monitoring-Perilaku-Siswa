<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;  // Untuk Laravel 8+
class PerilakuBaruDitambahkan implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    public function broadcastOn()
{
    // Simpan notifikasi ke database
    if ($this->notification['orangtua_id']) {
        Notification::create([
            'user_id' => $this->notification['orangtua_id'],
            'type' => 'App\Notifications\PerilakuBaruNotification',
            'notifiable_type' => 'App\Models\Siswa',
            'notifiable_id' => $this->notification['siswa_id'],
            'data' => json_encode($this->notification),
        ]);
    }

    // Kirim ke channel siswa dan orang tua terkait
    return [
        new Channel('siswa.notifications.' . $this->notification['siswa_id']),
        new Channel('orangtua.notifications.' . $this->notification['orangtua_id']),
    ];
}

    public function broadcastAs()
    {
        return 'perilaku-baru';
    }
}