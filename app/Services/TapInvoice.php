<?php
/**
 * Created by PhpStorm.
 * User: usamaahmed
 * Date: 7/16/17
 * Time: 6:27 PM
 */
namespace App\Services;

use Usama\Tap\PaymentContract;

class TapInvoice implements PaymentContract
{

    public $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * results Object :
     *  +"PaymentURL": "https://live.gotapnow.com/webpay.aspx?ref=207172017102625563&sess=KzN5mY1hZvlblLJi%2b%2fFQGJLvMBlE7W%2fD"
     * +"ReferenceID": "207172017102625563"
     * +"ResponseCode": "0"
     * +"ResponseMessage": "Success"
     * +"TapPayURL": "https://live.gotapnow.com/webpay.aspx"
     */
    public function storePayment()
    {
        // store the cart if you want from session()->get('cart')
        // store the payment results if you want in your DB by accessing to $this->response;
//        dd(json_decode($this->response->getBody()));
        // clear the cart
        session()->forget('cart');
        return redirect()->home();

    }
}
