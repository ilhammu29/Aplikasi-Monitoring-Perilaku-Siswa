<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PerilakuBaruDitambahkan implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Data perilaku yang akan dikirim ke frontend
     *
     * @var array
     */
    public array $data;

    /**
     * Create a new event instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Saluran tempat event akan dipancarkan
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('perilaku-channel');
    }

    /**
     * Nama event yang akan dikirim ke frontend
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'perilaku-baru';
    }
}
