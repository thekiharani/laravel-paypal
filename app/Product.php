<?php

namespace App;

use App\Order;
use App\Purchase;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public function purchases() {
    	return $this->hasMany(Purchase::class);
    }

    public function orders() {
    	return $this->belongsToMany(Order::class, 'purchases');
    }
    // custom attributes
	public function getTaxValueAttribute()
	{
	    return ($this->tax/100) * $this->price;
	}

	public function getLessTaxAttribute()
	{
	    return (1 - ($this->tax/100)) * $this->price;
	}
}
