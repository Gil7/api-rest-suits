<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';
    protected $fillable = [
        'nameClient'
    ];
    public function products(){
        return $this->belongsToMany('App\Product','product_sale')->withPivot('quantity','price');
    }
}
