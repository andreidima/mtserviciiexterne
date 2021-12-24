<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ObservatieFirma extends Mailable
{
    use Queueable, SerializesModels;

    public $observatie;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($observatie)
    {
        $this->observatie = $observatie;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $observatie = $this->observatie;

        $message = $this->markdown('mail.observatieFirma');

        $message->subject('Observații din teren');

        foreach ($observatie->poze as $poza){
            $message->attachFromStorage($poza->cale . $poza->nume);
        }
        // dd($message);


        return $message;
    }
}
