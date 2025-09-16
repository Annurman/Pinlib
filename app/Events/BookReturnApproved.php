<?php

namespace App\Events;

use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookReturnApproved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $borrowing;
    public $userId;

    public function __construct(Borrowing $borrowing)
    {
        $this->borrowing = $borrowing;
        $this->userId = $borrowing->user_id;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('user.' . $this->userId);
    }

    public function broadcastAs(): string
    {
        return 'book.return.approved';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => 'Pengembalian buku "' . $this->borrowing->book->title . '" telah disetujui.',
            'borrowing_id' => $this->borrowing->id,
        ];
    }
}
