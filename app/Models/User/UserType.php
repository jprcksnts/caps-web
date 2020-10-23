<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    public const ADMIN_TYPE_ID = 1;
    public const STAFF_TYPE_ID = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
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

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
