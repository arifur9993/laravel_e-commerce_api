<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSubCategory extends Model
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
    public function hasCategory()
    {
        return $this->belongsTo('App\Models\Product\ProductCategory', 'cat_id', 'id');
    }
    public function hasProduct()
    {
        return $this->hasMany('App\Models\Product\Product', 'sub_cat_id', 'id');
    }
}
