<?php

namespace App\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class NewMemberRegistered implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $member;
    public $adminId;

    public function __construct($member, $adminId)
    {
        $this->member = $member;
        $this->adminId = $adminId;
    }

    public function broadcastOn(): array
{
    return [
        new PrivateChannel('admin.' . $this->adminId),
    ];
}

    public function broadcastAs()
    {
        return 'member.registered';
    }
}
