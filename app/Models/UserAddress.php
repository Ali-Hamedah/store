<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
         'type', 'first_name', 'last_name', 'email', 'phone_number',
        'street_address', 'city', 'postal_code', 'state', 'country', 'default'
    ];
}
