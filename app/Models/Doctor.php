<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Doctor extends BaseModel
{
	protected $table = 'doctors';

	protected $fillable = [
    'name_kh',
    'name_en',
    'gender',
    'id_card',
    'phone',
    'email',
    'full_address',
    'address_district_id',
    'address_province_id',
    'address_commune',
    'address_village',
    'description',
    'created_by',
    'updated_by',
	];

  public function province()
  {
  	return $this->belongsTo(Province::class, 'address_province_id');
  }

  public function district()
  {
  	return $this->belongsTo(District::class, 'address_district_id');
  }
  
  public function recordLocked () {
		return true;
	}
}
