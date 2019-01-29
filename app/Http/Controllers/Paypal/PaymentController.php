<?php

namespace App\Http\Controllers\Paypal;

use App\Http\Controllers\Controller;
use App\Order;
use App\Traits\Paypal;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
	use Paypal;

    public function create() {
    	return $this->createPayment();
    }

    public function execute(Order $order) {
    	return $this->executePayment($order);
    }

    public function cancel() {
    	return 'Transaction Cancelled!';
    }

}
