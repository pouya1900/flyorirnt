<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return array
	 */
	public function toArray( $request ) {
		return [
			'id'        => $this->id,
			'name'      => $this->post_name,
			'title'     => $this->title,
			'content'     => $this->content,
			'image'     => $this->image,
			'updatedAt' => $this->updated_at,
			'createdAt' => $this->created_at,
		];
	}
}
