<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InventoryMovementType extends Model
{
    static $ORDER = 'order';
    static $SALE = 'sale';
}
