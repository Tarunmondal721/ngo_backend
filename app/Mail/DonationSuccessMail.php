<?php

namespace App\Mail;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonationSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $donation;

    public function __construct(Donation $donation)
    {
        $this->donation = $donation->fresh(); // ensure latest data
    }

    public function build()
    {
        return $this->subject('Thank You for Your Donation!')
                    ->view('emails.donation-success');
    }
}