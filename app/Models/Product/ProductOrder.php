<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'quantity', 'expected_arrival_date',
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
