<?php

namespace App\Models;

use App\Models\BaseModel;


class Patient extends BaseModel
{
  protected $table = 'patients';

  protected $fillable = [
    'name',
    'id_card',
    'email',
    'phone',
    'gender',
    'age',
    'age_type',
    'description',
    'full_address',
    'address_village',
    'address_commune',
    'address_district_id',
    'address_province_id',
    'address_code',
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

  public function full_address()
  {
    return $this->belongsTo(FourLevelAddress::class, 'address_code', '_code');
  }

  public function invoices () {
    return $this->hasMany('App\Models\Invoice', 'patient_id');
  }

  public function prescriptions () {
    return $this->hasMany('App\Models\Prescription', 'patient_id');
  }

  public function labors () {
    return $this->hasMany('App\Models\Labor', 'patient_id');
  }

  public function echoes () {
    return $this->hasMany('App\Models\Echoes', 'patient_id');
  }

  public function recordLocked($list_id_include = [])
	{
    if (sizeof($list_id_include) > 0) {
      return in_array($this->id, $list_id_include);
    } else {
      return $this->invoices->count() > 0 || $this->prescriptions->count() || $this->labors->count() || $this->echoes->count();
    }
	}
}
