<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_type_id', 'name', 'uuid', 'code', 'quantity',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function productOrders()
    {
        return $this->hasMany(ProductOrder::class);
    }

    public function productSales()
    {
        return $this->hasMany(ProductSale::class);
    }
}
