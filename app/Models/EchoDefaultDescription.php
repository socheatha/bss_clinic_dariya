<?php

namespace App\Models;

class EchoDefaultDescription extends BaseModel
{
	protected $table = 'echo_default_descriptions';

	protected $fillable = [
		'name', 'slug', 'description',
	];

	public function echos()
	{
		return $this->hasMany('App\Models\Echoes', 'echo_default_description_id');
	}

	public function recordLocked()
	{
		return $this->echos->count() > 0;
	}
}
