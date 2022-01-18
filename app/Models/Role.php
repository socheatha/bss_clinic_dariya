<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Role extends Model
{
  protected $table = 'roles';

  protected $fillable = [
    'name', 'description',
  ];

  public function users()
  {
    return $this->hasMany('App\Models\User', 'role_id');
  }

  public static function getSelectData()
  {
    if (Auth::user()->roles->first()->id == 1) {
      $collection = parent::all();
    } else {
      $collection = parent::where('id', '>', 1)->get();
    }

    $items = [];
    foreach ($collection as $model) {
      $items[$model->name] = $model->name;
    }
    return $items;
  }

  public function recordLocked()
	{
		return $this->users->count() > 0 || $this->id <=3;
	}
}
