<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Session extends Model {
	protected $primaryKey = 'session_id';

	protected $guarded = [ 'session_id' ];

	public $incrementing = false;


	public function get_session( $render_code ) {

		$exp = Carbon::now()->subMinutes( 10 );

		$this->where( 'created_at', '<', $exp )->delete();

		$sessions = $this->where( 'render', $render_code )->get();


		$sessions = json_decode( json_encode( $sessions ), true );

		if ( ! empty( $sessions ) ) {
			$session = $sessions[0]["session_id"];

			return $session;
		} else {
			return 0;
		}

	}


}
