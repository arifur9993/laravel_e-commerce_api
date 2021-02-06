<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $guarded = [
        'id'
    ];
    public function hasRole()
    {
        return $this->hasMany('App\Models\Auth\User', 'role_id', 'id');
        
    }
    public function hasPermissions()
    {
        return $this->hasMany('App\Models\Auth\RoleHasPermission', 'role_id', 'id');
    }
}
