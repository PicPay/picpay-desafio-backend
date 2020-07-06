<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationTransactionEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.transaction')
                    ->subject('Desafio PicPay :: Transação')
                    ->with([
                        'user' => $this->parameters['payer'],
                        'value' => $this->parameters['value'],
                        'message' => $this->parameters['message'],
                    ]);
    }
}
