<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Member;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewMemberNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $member;

    public function __construct($member)
    {
        $this->member = $member;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'member_request',
            'message' => 'Ada pengajuan member baru dari ' . $this->member->user->name,
            'member_id' => $this->member->id,
            'user_id' => $this->member->user_id,
            'library_id' => $this->member->library_id,
            'link' => route('members.index'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'type' => 'member_request',
            'message' => 'Ada pengajuan member baru dari ' . $this->member->user->name,
            'member_id' => $this->member->id,
            'user_id' => $this->member->user_id,
            'library_id' => $this->member->library_id,
            'link' => route('members.index'),
        ]);
    }
}
