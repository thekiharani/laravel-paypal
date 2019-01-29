<?php

namespace App\Traits;

use App\Http\Controllers\Controller;
use App\Product;
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
	
    public function createPayment() {
    	$item1 = new Item();
		$item1->setName('Ground Coffee 40 oz')
		    ->setCurrency('USD')
		    ->setQuantity(1)
		    ->setSku("123123") // Similar to `item_number` in Classic API
		    ->setPrice(20);
		$item2 = new Item();
		$item2->setName('Granola bars')
		    ->setCurrency('USD')
		    ->setQuantity(1)
		    ->setSku("321321") // Similar to `item_number` in Classic API
		    ->setPrice(20);

		$itemList = new ItemList();
        $itemList->setItems(array($item1, $item2));
    	$payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $details = new Details();
		$details->setShipping(20)
		    ->setTax(25)
		    ->setSubtotal(40);

	    $amount = new Amount();
		$amount->setCurrency("USD")
		    ->setTotal(85)
		    ->setDetails($details);

		$transaction = new Transaction();
		$transaction->setAmount($amount)
		    ->setItemList($itemList)
		    ->setDescription("Payment description")
		    ->setInvoiceNumber(uniqid());

		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl(route('payment.execute'))
		    ->setCancelUrl(route('payment.cancel'));

		$payment = new Payment();
		$payment->setIntent("sale")
		    ->setPayer($payer)
		    ->setRedirectUrls($redirectUrls)
		    ->setTransactions(array($transaction));

		$payment->create($this->contexAPI());

		return redirect($payment->getApprovalLink());
    }

    public function executePayment() {
    	$paymentId = request()->paymentId;
        $payment = Payment::get($paymentId, $this->contexAPI());

        $execution = new PaymentExecution();
        $execution->setPayerId(request()->PayerID);

        $transaction = new Transaction();
	    $amount = new Amount();

	    $details = new Details();
	    $details->setShipping($ship)
		        ->setTax($tax)
		        ->setSubtotal($cost);

		$amount->setCurrency('USD');
	    $amount->setTotal($totat);
	    $amount->setDetails($details);
	    $transaction->setAmount($amount);

	    $execution->addTransaction($transaction);

	    $result = $payment->execute($execution, $this->contexAPI());

        return $result;
    }

}