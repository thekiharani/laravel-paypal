<?php

namespace App\Traits;

trait smsAPI {
	
    public function sendVerificationCode($name, $phone, $code) {
        $headers = array();
        $headers[] = "ApiKey:".env('SMS_API_KEY'); 
        $headers[] = "Content-type:application/json" ;
        $msg = ["message" => "Hello ".$name.",\nYour ".env("APP_NAME")." verification code is: ".$code."\n\n", "recipients" => $phone];
        $json = json_encode($msg);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.sematime.com/v1/".env('SMS_USER_ID')."/messages");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $output = curl_exec($ch);
        curl_close($ch);
    }

}