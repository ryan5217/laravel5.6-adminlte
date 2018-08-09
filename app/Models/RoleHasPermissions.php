<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleHasPermissions extends Model
{
     protected $table = 'role_has_permissions';
     protected $primaryKey = 'id';
     // public $timestamps = false;
     protected $guarded = []; //不可以修改的属性
     protected $fillable = []; //可以修改的属性
     // protected $hidden = ['create_uid'];
     // protected $dates = [];
}
