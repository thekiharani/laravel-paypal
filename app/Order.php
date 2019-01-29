<?php

namespace App;

use App\Product;
use App\Purchase;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function purchases() {
    	return $this->hasMany(Purchase::class);
    }
    public function products() {
    	return $this->belongsToMany(Product::class, 'purchases');
    }
    public function getSubTotalAttribute()
	{
	    return $this->purchases->sum('amount');
	}
}
