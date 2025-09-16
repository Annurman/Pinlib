<?php
// app/Events/BorrowingCreated.php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Borrowing;

class BorrowingCreated implements ShouldBroadcast
{
    public $borrowing;

    public function __construct(Borrowing $borrowing)
    {
        $this->borrowing = $borrowing->load('user'); // pastikan relasi user ikut
    }

    public function broadcastOn()
    {
        return new PrivateChannel('admin.' . $this->borrowing->admin_id);
    }

    public function broadcastAs()
    {
        return 'borrowing.created';
    }
}
