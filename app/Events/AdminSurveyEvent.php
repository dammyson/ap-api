<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminSurveyEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $admin;
    public $survey;
    public $action;

    /**
     * Create a new event instance.
     */
    public function __construct($admin, $survey, $action)
    {
        $this->admin = $admin;
        $this->survey = $survey;
        $this->action = $survey;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
