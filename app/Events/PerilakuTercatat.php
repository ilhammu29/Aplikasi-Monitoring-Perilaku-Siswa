<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PerilakuTercatat implements ShouldBroadcast
{
    use SerializesModels;

    public $siswaNama;
    public $kategori;
    public $nilai;

    public function __construct($siswaNama, $kategori, $nilai)
    {
        $this->siswaNama = $siswaNama;
        $this->kategori = $kategori;
        $this->nilai = $nilai;
    }

    public function broadcastOn()
    {
        return new Channel('notifikasi-channel');
    }

    public function broadcastAs()
    {
        return 'perilaku-tercatat';
    }
}
