<?php

namespace App\Http\Controllers\Paypal;

use App\Http\Controllers\Controller;
use App\Product;
use App\Traits\Paypal;
use PayPal\Api\Item;

class PaymentController extends Controller
{
	use Paypal;

    public function create() {
    	return $this->createPayment();
    }

    public function execute() {
    	return $this->executePayment();
    }

    public function cancel() {
    	return 'Transaction Cancelled!';
    }

}
