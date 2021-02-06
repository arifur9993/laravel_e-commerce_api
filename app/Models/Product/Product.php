<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
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
    public function hasCat()
    {
        return $this->belongsTo('App\Models\Product\ProductCategory', 'cat_id', 'id');
    }
    public function hasSubCat()
    {
        return $this->belongsTo('App\Models\Product\ProductSubCategory', 'sub_cat_id', 'id');
    }
    public function hasCart()
    {
        return $this->hasMany('App\Models\Cart\Cart', 'product_id', 'id');
    }
    public function hasOrder()
    {
        return $this->hasMany('App\Models\Order\Order', 'product_id', 'id');
    }
}
