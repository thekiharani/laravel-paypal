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

	protected $apiContext;
	protected $products;
	
	public function __construct() {
		$this->apiContext = new \PayPal\Rest\ApiContext(
	        new \PayPal\Auth\OAuthTokenCredential(
	            config('services.paypal.id'), // ClientID
	            config('services.paypal.secret') // ClientSecret
	        )
	    );

	    $this->products = Product::all();
	}
	
    public function createPayment() {
    	$items = array();
	    foreach ($this->products as $product) {
	    	$item = new Item();
			$item->setName($product->name)
			    ->setCurrency('USD')
			    ->setQuantity(1)
			    ->setSku(rand(100000, 999999)) // Similar to `item_number` in Classic API
			    ->setPrice($product->price);

			$items[] = $item;
	    }
    	$payer = new Payer();
        $payer->setPaymentMethod("paypal");

		$itemList = new ItemList();
        $itemList->setItems($items);

        $details = new Details();
		$details->setShipping($this->products->sum('shipping'))
		    ->setTax($this->products->sum('tax'))
		    ->setSubtotal($this->products->sum('price'));

	    $amount = new Amount();
		$amount->setCurrency("USD")
		    ->setTotal($this->products->sum('shipping') + $this->products->sum('tax') + $this->products->sum('price'))
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

		$payment->create($this->apiContext);

		return redirect($payment->getApprovalLink());
    }

    public function executePayment() {
    	$paymentId = request()->paymentId;
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(request()->PayerID);

        $transaction = new Transaction();
	    $amount = new Amount();

	    $details = new Details();
	    $details->setShipping($this->products->sum('shipping'))
		        ->setTax($this->products->sum('tax'))
		        ->setSubtotal($this->products->sum('price'));

		$amount->setCurrency('USD');
	    $amount->setTotal($this->products->sum('shipping') + $this->products->sum('tax') + $this->products->sum('price'));
	    $amount->setDetails($details);
	    $transaction->setAmount($amount);

	    $execution->addTransaction($transaction);

	    $result = $payment->execute($execution, $this->apiContext);

        return $result;
    }

}