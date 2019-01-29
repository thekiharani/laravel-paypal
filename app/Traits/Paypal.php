<?php

namespace App\Traits;

use App\Http\Controllers\Controller;
use App\Product;
use App\order;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

trait Paypal {
    private function contexAPI() {
		$apiContext = new \PayPal\Rest\ApiContext(
	        new \PayPal\Auth\OAuthTokenCredential(
	            config('services.paypal.id'), // ClientID
	            config('services.paypal.secret') // ClientSecret
	        )
	    );

	    return $apiContext;
	}
	
    public function createPayment($order) {
    	$items = array();
    	foreach ($order->purchases as $purchase) { 
    		$item = new Item();
			$item->setName($purchase->product->name)
			    ->setCurrency('USD')
			    ->setQuantity($purchase->qty)
			    ->setSku("123123") // Similar to `item_number` in Classic API
			    ->setPrice($purchase->product->less_tax);

			$items[] = $item;
	    }

	    $itemList = new ItemList();
        $itemList->setItems($items);
    	$payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $details = new Details();
		$details->setShipping(0.00)
		    ->setTax($order->purchases->sum('tax_value'))
		    ->setSubtotal($order->purchases->sum('less_tax'));

	    $amount = new Amount();
		$amount->setCurrency("USD")
		    ->setTotal($order->purchases->sum('amount'))
		    ->setDetails($details);

		$transaction = new Transaction();
		$transaction->setAmount($amount)
		    ->setItemList($itemList)
		    ->setDescription("Payment description")
		    ->setInvoiceNumber(uniqid());

		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl(route('payment.execute', $order->id))
		    ->setCancelUrl(route('payment.cancel'));

		$payment = new Payment();
		$payment->setIntent("sale")
		    ->setPayer($payer)
		    ->setRedirectUrls($redirectUrls)
		    ->setTransactions(array($transaction));

		$payment->create($this->contexAPI());

		return redirect($payment->getApprovalLink());
    }

    public function executePayment($order) {
    	$paymentId = request()->paymentId;
        $payment = Payment::get($paymentId, $this->contexAPI());

        $execution = new PaymentExecution();
        $execution->setPayerId(request()->PayerID);

        $transaction = new Transaction();
	    $amount = new Amount();

	    $details = new Details();
	    $details->setShipping(0.00)
		        ->setTax($order->purchases->sum('tax_value'))
		        ->setSubtotal($order->purchases->sum('less_tax'));

		$amount->setCurrency('USD');
	    $amount->setTotal($order->purchases->sum('amount'));
	    $amount->setDetails($details);
	    $transaction->setAmount($amount);

	    $execution->addTransaction($transaction);

	    $result = $payment->execute($execution, $this->contexAPI());

        return $result;
    }

}