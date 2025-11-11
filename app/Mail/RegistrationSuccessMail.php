<?php
// app/Mail/RegistrationSuccessMail.php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Registration;
use App\Models\Event;

class RegistrationSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $event;

    public function __construct(Contact $registration, Event $event)
    {
        $this->registration = $registration;
        $this->event = $event;
    }

    public function build()
    {
        return $this->subject("You're Registered! 🎉 - {$this->event->title}")
                    ->view('emails.registration_success');
    }
}