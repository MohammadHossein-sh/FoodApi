<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Category;
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
    public function index(Request $request)
    {
        $paginate =  $request->input('paginate', 0);
        if ($paginate !== 0) {
            $orders = Order::paginate($paginate);
            $links = OrderResource::collection($orders)->response()->getData()->links;
            $meta = OrderResource::collection($orders)->response()->getData()->meta;

            return  $this->successPagintaeResponse("orders", OrderResource::collection($orders), $links, $meta, $paginate, 200, "List of orders " . $paginate . " to " . $paginate . ":");
        } else {
            $orders = Order::all();
            return $this->successResponse(OrderResource::collection($orders), 200, "List all of orders:");
        }
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
            'order_items' => 'required',
            'order_items.*.product_id' => 'required|regex:/^[\p{L}\p{N}]+$/u',
            'order_items.*.quantity' => 'required|regex:/^[\p{L}\p{N}]+$/u',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        $orders = [];
        foreach ($request->order_items as $order) {
            $product = Product::find($order['product_id']);
            if ($product !== null && $product->quantity >= $order['quantity']) {
                DB::beginTransaction();
                echo $order['product_id'];
                $order = Order::create([
                    'user_id' => $user->id,
                    'product_id' => $order['product_id'],
                    'price' => $product->price,
                    'quantity' => $order['quantity'],
                    'subtotal' => $order['quantity'] * $product->price
                ]);
                array_push($orders, $order);
                $product->update([
                    'quantity' => $product->quantity - $order['quantity'],
                ]);
                DB::commit();
            } else {
                return $this->errorResponse('The product stock is less than the selected quantity', 422);
            }
        }
        return  $this->successResponse(OrderResource::collection($orders), 200, "Your order has been registered");
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $user = auth()->user();
        if ($order->user_id == $user->id) {
            return $this->successResponse(new OrderResource($order), 200, "show order");
        } else {
            return $this->errorResponse('This order was not found for this user', 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        DB::beginTransaction();
        $order->delete();
        DB::commit();
        return  $this->successResponse(new OrderResource($order), 200, "deleted successfully");
    }

    public function restore(Order $order)
    {
        DB::beginTransaction();
        $order->restore();
        DB::commit();
        return  $this->successResponse(new OrderResource($order), 200, "change off delete successfully");
    }
    public function deletes()
    {
        $orders = Order::onlyTrashed()->get();

        $ordersResource = OrderResource::collection($orders);

        return  $this->successResponse($ordersResource, 200, "list deleted successfully");
    }
    public function userOrder()
    {
        $user = auth()->user();
        $orders = $user->orders;
        return  $this->successResponse(OrderResource::collection($orders), 200, "list of user logined successfully");
    }
}
