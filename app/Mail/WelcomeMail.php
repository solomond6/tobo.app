<?php

namespace App\Mail;
use App\Model\User;
use App\Model\VerifyUser;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'temisolo17@gmail.com';
        $name = 'Tobo App';
        $subject = 'Agent Registration';
        return $this->view('emails.verifyUser')->from($address, $name)->subject($subject);
    }
}