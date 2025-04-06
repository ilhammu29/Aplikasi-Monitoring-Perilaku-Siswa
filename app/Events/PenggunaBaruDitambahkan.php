<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PenggunaBaruDitambahkan implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nama;
    public $role;

    public function __construct($nama, $role)
    {
        $this->nama = $nama;
        $this->role = $role;
    }

    public function broadcastOn()
    {
        return new Channel('notifikasi-admin');
    }

    public function broadcastAs()
    {
        return 'pengguna.ditambahkan';
    }
}

