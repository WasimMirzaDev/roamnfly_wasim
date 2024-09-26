<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $name;

    public function __construct($url, $name)
    {
        $this->url = $url;
        $this->name = $name;
    }

    public function build()
    {
        return $this->view('emails.reset_password')
                    ->subject('Reset Password')
                    ->with([
                        'url' => $this->url,
                        'name' => $this->name,
                    ]);
    }
}
