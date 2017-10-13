<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';
    protected $fillable = [
        //return = limit date and returned is a bolean to validate if thge products was returned
        'nameClient','return','returned'
    ];
    public function products(){
        return $this->belongsToMany('App\Product','product_rental')->withPivot('quantity','price');
    }
}
