<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    static $order = 'product_order';
    static $sale = 'product_sale';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'tx_id', 'quantity', 'r_quantity',
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
}
