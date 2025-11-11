<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $otp;
    public $eventName;

    public function __construct($otp, $eventName)
    {
        $this->otp = $otp;
        $this->eventName = $eventName;
    }

    public function build()
    {
        return $this->subject("Your OTP for {$this->eventName}")
            ->view('emails.otp');
    }
}
