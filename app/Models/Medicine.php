<?php

namespace App\Models;

use App\Models\BaseModel;

class Medicine extends BaseModel
{
	protected $table = 'medicines';

	protected $fillable = [
		'name', 'price', 'code', 'usage_id', 'description', 'created_by', 'updated_by',
	];

	public function usage()
	{
		return $this->belongsTo(Usage::class, 'usage_id');
	}

	public function prescriptionDetails()
	{
		return $this->hasMany('App\Models\PrescriptionDetail', 'medicine_id');
	}

	public function recordLocked () {
		return $this->prescriptionDetails->count() > 0;
	}
}
