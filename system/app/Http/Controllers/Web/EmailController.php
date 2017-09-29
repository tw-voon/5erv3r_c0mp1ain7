<?php

namespace App\Http\Controllers\Web;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailController extends Mailable
{
	use Queueable, SerializesModels;

    public $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function build()
    {
        return $this->view('email.send')
        			->from('from@example.com', "tw-voon")
                    ->subject("Reporting Mail");
    }
}
