<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $eventInfo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->eventInfo = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('williamswaz18@example.com')
            ->subject('Invitacion al evento')
            ->view('mail.invitation')->with([
            'eventInfo' => $this->eventInfo,
        ]);
    }
}
