<?php

namespace App;

use App\Order;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public $timestamps = false;

    public function product() {
    	return $this->belongsTo(Product::class);
    }

    public function order() {
    	return $this->belongsTo(Order::class);
    }

    public function getTaxValueAttribute()
	{
	    return $this->product->tax_value * $this->qty;
	}

	public function getLessTaxAttribute()
	{
	    return $this->product->less_tax * $this->qty;
	}
}
