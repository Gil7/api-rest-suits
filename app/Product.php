<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name', 'description','price','stock','rental'
    ];
    public function sizes(){
        return $this->belongsToMany('App\Size','product_size');
    }
    public function rentals(){
        return $this->belongsToMany('App\Rental','product_sale')->withPivot('quantity','price');
    }
    public function sales(){
        return $this->belongsToMany('App\Sale','product_sale')->withPivot('quantity','price');
    }

}
