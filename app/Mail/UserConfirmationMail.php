<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UserConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user, $verifyLink;
    public function __construct($user, $verifyLink)
    {
        $this->user = $user;
        $this->verifyLink = $verifyLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'no-reply@demuria.id';
        $subject = 'Selamat Anda sudah berhasil daftar';
        $name = 'Demuria ERP';

        return $this->view('emails.user_confirmation')
                    ->from($address, $name)
                    ->subject($subject)
                    ->with([
                        'nama' => $this->user->fullname,
                        'verify_link' => $this->verifyLink,
                        'ka_icon' => url(Storage::url('appicon.png'))
                    ]);
    }
}
