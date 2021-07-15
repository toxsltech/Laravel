<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailFromAdmin extends Mailable
{
    use Queueable, SerializesModels;
    
    public $data;
    
    public $view;
    
    public $from_email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($view, $data, $from)
    {
        $this->data = $data;
        $this->view = $view;
        $this->from_email = $from;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->from_email)->view($this->view);
    }
}
