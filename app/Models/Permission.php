<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
  protected $table = 'permissions';

  protected $fillable = [
    'name', 'description',
  ];

  public function users()
  {
    return $this->hasMany('App\Models\User', 'role_id');
  }

  public function roles()
  {
    return $this->belongsToMany(
      config('permission.models.role'),
      config('permission.table_names.role_has_permissions'),
      'permission_id',
      'role_id'
    );
  }

  public static function getSelectData()
  {
    $collection = parent::where('id', '>', 1)->get();

    $items = [];
    foreach ($collection as $model) {
      $items[$model->name] = $model->name;
    }
    return $items;
  }

  public function recordLocked()
  {
    return $this->roles->count() > 0 ||  $this->id <= 18;
  }
}
