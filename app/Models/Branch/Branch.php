<?php

namespace App\Models\Branch;

use App\Models\Product\ProductSale;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'city',
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

    public function productSales()
    {
        return $this->hasMany(ProductSale::class);
    }
}
