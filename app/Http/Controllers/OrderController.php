<?php

namespace App\Http\Controllers;

use App\Order;
use App\Purchase;
use App\Traits\Paypal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
	use Paypal;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	//
    }

    public function purchase() {
    	//
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$order = new Order;
        $order->ref_code = 'TKS-'.rand(100000, 999999);
        $order->save();

         for ($i=0; $i < count($request->price); $i++) { 
         	$purchase = new Purchase;
         	$purchase->qty        = $request->qty[$i];
	        $purchase->price      = $request->price[$i];
	        $purchase->tax        = $request->tax[$i];
	        $purchase->total      = $request->total[$i];
	        $purchase->amount     = $request->total[$i] * $request->qty[$i];
	        $purchase->product_id = $request->product_id[$i];
	        $purchase->order_id   = $order->id;
	        $purchase->save();
        }
    	DB::beginTransaction();
    	try {
	        return $this->createPayment($order);
	        DB::commit();
        } catch (\Exception $e) {
        	$order->purchases()->delete();
        	$order->delete();
		    DB::rollback();
		    return redirect()->back()->withInput()->with('error', $e->getMessage());
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
