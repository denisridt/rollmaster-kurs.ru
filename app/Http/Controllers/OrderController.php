<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Orderlist;
use App\Models\Products;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout(Request $request){
        $user_id = $request->user()->id;

        $carts = Cart::where('user_id', $user_id)->get();

        foreach ($carts as $cart){
            $product = Products::find($cart->product_id);
            if ($product->quantity < $cart->quantity) {
                throw new ApiException(500, 'Не работает');
            }
        }

        $order = new Order(['user_id' => $user_id]);
        $order->save();

        foreach ($carts as $cart){
            $product = Products::find($cart->product_id);
            $newOrderlist = new Orderlist();
            $newOrderlist->order_id = $order->id;
            $newOrderlist->product_id = $cart->product_id;
            $newOrderlist->quantity = $cart->quantity;
            $newOrderlist->price = $product->price;
            $newOrderlist->save();

            $product->quantity -= $cart->quantity;
            $product->save();
        }
        Cart::where('user_id', $user_id)->delete();
        return response()->json($order)->setStatusCode(200, 'Заказ оформлен');
    }
}
