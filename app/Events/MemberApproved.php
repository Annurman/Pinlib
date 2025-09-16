<?php

// app/Events/MemberApproved.php

namespace App\Events;

use App\Models\Member;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;

class MemberApproved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function broadcastOn()
    {
        return new Channel('admin.channel');
    }

    public function broadcastAs()
    {
        return 'member.approved';
    }
}
