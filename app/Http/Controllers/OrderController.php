<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'order_items.*' => 'required',
            'order_items.*.product_id' => 'required|regex:/^[a-zA-Z0-9آ-ی\s]+$/',
            'order_items.*.quantity' => 'required|regex:/^[a-zA-Z0-9آ-ی\s]+$/',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        foreach ($request->order_items as $order) {
            $product = Product::find($order['product_id']);
            if ($product !== null) {
                DB::beginTransaction();
                $order = Order::create([
                    'user_id' => $user->id,
                    'product_id' => $order['product_id'],
                    'price' => $product->price,
                    'quantity' => $order['quantity'],
                    'subtotal' => $order['quantity'] * $product->price
                ]);
                DB::commit();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
