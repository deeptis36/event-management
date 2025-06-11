<?php

namespace App\Notifications;

use App\Models\TalkProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ProposalReviewedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $proposal;

    public function __construct(TalkProposal $proposal)
    {
        $this->proposal = $proposal;
    }

    public function via($notifiable)
    {
        return ['mail']; // You can add 'database', 'broadcast', etc. if needed
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Talk Proposal Has Been Reviewed')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your proposal titled "' . $this->proposal->title . '" has been reviewed.')
            ->line('Status: ' . ucfirst($this->proposal->status))
            ->action('View Proposal', url('/speaker/proposals/' . $this->proposal->id))
            ->line('Thank you for submitting your talk!');
    }

    public function toArray($notifiable)
    {
        return [
            'proposal_id' => $this->proposal->id,
            'title' => $this->proposal->title,
            'status' => $this->proposal->status,
        ];
    }
}
