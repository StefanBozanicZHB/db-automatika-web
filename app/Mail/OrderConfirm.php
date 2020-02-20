<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Order;

class OrderConfirm extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;

        $year = date('Y', strtotime($order->date));

        $this->subject('Faktura '.$year.'/'.$order->account_number);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {


        $year = date('Y', strtotime($this->order->date));

        return $this->view('emails.order_confirm')
            ->with(['order' => $this->order])
            ->attach('invoices/Faktura_'.$year.'_'.$this->order->account_number.'.pdf' );
    }
}

