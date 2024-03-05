<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendMailForUserRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public $page_name;

    public $subject_line;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
        $this->page_name = $this->details['page_name'];
        $this->subject_line = $this->details['subject_line'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->subject($this->subject_line)->view($this->page_name);
    }
}
