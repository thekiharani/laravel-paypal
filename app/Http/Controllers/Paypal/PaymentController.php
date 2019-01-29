<?php

namespace App\Http\Controllers\Paypal;

use App\Http\Controllers\Controller;
use App\Product;
use App\Traits\Paypal;
use Illuminate\Http\Request;
use PayPal\Api\Item;
use PayPal\Api\ItemList;

class PaymentController extends Controller
{
	use Paypal;

    public function create() {
    	return $this->createPayment();
    }

    public function execute() {
    	dd('success');
    	return $this->executePayment();
    }

    public function cancel() {
    	return 'Transaction Cancelled!';
    }

}
