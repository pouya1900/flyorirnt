<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AirlineResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'id'=>$this->id,
			'code'=>$this->code,
			'name'=>$this->name,
			'agb'=>$this->agb,
			'image'=>$this->image,
		];
	}
}
