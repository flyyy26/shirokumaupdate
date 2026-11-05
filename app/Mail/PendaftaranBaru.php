<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendaftaranBaru extends Mailable
{
    use SerializesModels;

    public $pendaftaran;

    public function __construct($pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
    }

    public function build()
    {
        return $this->subject('Pendaftaran Baru')
                    ->view('emails.pendaftaran_baru');
    }
}