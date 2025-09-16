<?php

// app/Events/ReturnRequested.php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\ReturnRequest;
use App\Models\Borrowing;

class ReturnRequested implements ShouldBroadcast
{
    public $borrowing;

    public function __construct(Borrowing $borrowing)
    {
        $this->borrowing = $borrowing->load('user');
    }

    public function broadcastOn()
    {
        return new PrivateChannel('admin.' . $this->borrowing->library_id); // sesuaikan dengan id admin pemilik perpustakaan
    }

    public function broadcastAs()
    {
        return 'return.requested';
    }
}
