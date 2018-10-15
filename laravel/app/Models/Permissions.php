<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Permissions extends Permission
{
    // protected $table = 'permissions';
    // protected $primaryKey = 'id';
    // // public $timestamps = false;
    // protected $guarded = []; //不可以修改的属性
    // protected $fillable = []; //可以修改的属性
    // // protected $hidden = ['create_uid'];
    // // protected $dates = [];
}
