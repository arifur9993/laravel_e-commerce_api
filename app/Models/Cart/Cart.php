<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
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
    public function hasProduct()
    {
        return $this->belongsTo('App\Models\Product\Product', 'product_id', 'id');
    }
    public function hasUser()
    {
        return $this->belongsTo('App\Models\Auth\User', 'user_id', 'id');
    }
}
