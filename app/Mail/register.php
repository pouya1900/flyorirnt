<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class register extends Mailable
{
	use Queueable, SerializesModels;

	public $lang;
	public $link;


	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($lang , $link)
	{
		$this->lang=$lang;
		$this->link=$link;

	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('front.email.register_email');
	}
}
