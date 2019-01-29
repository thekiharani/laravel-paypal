<?php

namespace App\Paypal;

class Paypal {
	protected $apiContext;
	
	public function __construct() {
		$this->apiContext = new \PayPal\Rest\ApiContext(
	        new \PayPal\Auth\OAuthTokenCredential(
	            config( key: 'services.paypal.id'), // ClientID
	            config( key: 'services.paypal.secret') // ClientSecret
	        )
	    );
	}
}