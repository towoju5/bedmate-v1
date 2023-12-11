<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OtpVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $username;

    public function __construct($otp, $username=null)
    {
        $this->otp = $otp;
        $this->username = $username;
    }

    public function build()
    {
        return $this->view('mail.otp')
            ->with([
                'otp' => $this->otp,
                'user'=> $this->username,
            ])
<<<<<<< HEAD
            ->subject('Your E-mail Verification Code');
=======
            ->subject('Your OTP for email verification');
>>>>>>> d9c9e64fa65359c8b436f513e49a8158be33773b
    }
}