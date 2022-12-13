<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendDataPayPointEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $paypont;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($paypont,$password)
    {

        $this->password = $password;
        $this->paypont = $paypont;

        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.paypoint.info',[
            'paypont' => $this->paypont,
            'password' => $this->password
        ]);
    }
}
