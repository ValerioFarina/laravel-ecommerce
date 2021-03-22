<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'email',
        'name',
        'address',
        'city',
        'province',
        'postalcode'
    ];

    public function products() {
        return $this->belongsToMany('App\Product')->withPivot('quantity');
    }

    public function payments() {
        return $this->hasMany('App\Payment');
    }
}
