<?php

namespace App\Models;

use App\Models\BaseModel;

class Usage extends BaseModel
{
	protected $table = 'usages';

	protected $fillable = [
		'name', 'description', 'created_by', 'updated_by',
	];

	public function medicines()
	{
		return $this->hasMany('App\Models\Medicine', 'usage_id');
	}

	public function prescriptionDetails()
	{
		return $this->hasMany('App\Models\PrescriptionDetail', 'medicine_usage');
	}

	public function recordLocked () {
		return $this->prescriptionDetails->count() > 0 || $this->medicines->count() > 0;
	}
}
