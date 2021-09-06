<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CetakPurchasingMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $purchasing, $verifyLink;
    public function __construct($purchasing, $verifyLink)
    {
        $this->purchasing = $purchasing;
        $this->verifyLink = $verifyLink;
        // $this->detail = $detail->nama;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'no-reply@demuria.id';
        $subject = 'Invoice Purchasing Order Bizplan.id';
        $name = 'Demuria ERP';

        return $this->view('emails.invoice')
                    ->from($address, $name)
                    ->subject($subject)
                    ->with([
                        'nama' => $this->purchasing->supplier,
                        'email'=> $this->purchasing->email,
                        'category'=> $this->purchasing->category,
                        'verify_link' => $this->verifyLink,
                        // 'item' => $this->detail->nama,
                        // 'harga' => $this->detail->harga,
                        // 'quantity' => $this->detail->qty,
                        // 'diskon' => $this->detail->diskon,
                        // 'unit' => $this->detail->satuan


                    ]);
    }
}
