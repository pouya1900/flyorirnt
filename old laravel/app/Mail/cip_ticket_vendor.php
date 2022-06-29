<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class cip_ticket_vendor extends Mailable
{
    use Queueable, SerializesModels;

	public $lang;
	public $file_path;


	/**
     * Create a new message instance.
     *
     * @return void
     */
	public function __construct($lang , $file_path)
	{
		$this->lang=$lang;
		$this->file_path=$file_path;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('front.email.cip_ticket_vendor')->attach($this->file_path);
	}
}
