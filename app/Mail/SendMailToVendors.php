<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailToVendors extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {

    	$pdf = $details['pdf'];
        $this->details = $details;
        $this->pdf = base64_encode($pdf);
    }


    /*attach('/home/mohini5/Desktop/', [
	      'as' => 'rfi_quotation16-Jan-2020.pdf',
	      'mime' => 'application/pdf',
	  ]);*/


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Laxyo Energy')
                    ->view('request_for_item.SendMail')->attachData(base64_decode($this->pdf), "Laxyo Enery Quotation Request.pdf", [
				                'mime' => 'application/pdf',
				            ]);
    }
}
