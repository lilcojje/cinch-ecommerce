<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $items;
    public $total_amount;

    public function __construct($name, $items, $total_amount)
    {
        $this->name = $name;
        $this->items = $items;
        $this->total_amount = $total_amount;
    }

    public function build()
    {
        return $this->subject('Your Order Confirmation')
                    ->view('emails.order_summary');
    }
}
