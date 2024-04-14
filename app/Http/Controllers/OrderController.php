<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\Carts;
use App\Models\Order;
use App\Models\Orderlist;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show(Request $request, $orderId)
    {
        // Получаем текущего пользователя
        $user = auth()->user();

        // Получаем заказ по его идентификатору и пользователю
        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->first();

        if (!$order) {
            return response()->json(['error' => 'Заказ не найден'], 404);
        }

        // Получаем детали заказа с продуктами
        $orderDetails = OrderList::where('order_id', $order->id)
            ->with('product')
            ->get();

        // Формируем данные для чека
        $checkData = [
            'order_id' => $order->id,
            'order_date' => $order->created_at,
            'order_details' => $orderDetails->map(function ($detail) {
                return [
                    'product_name' => $detail->product->name,
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                    'total' => $detail->quantity * $detail->price,
                ];
            }),
            'total_amount' => $orderDetails->sum(function ($detail) {
                return $detail->quantity * $detail->price;
            }),
        ];

        return response()->json(['check' => $checkData]);
    }
    public function checkout(Request $request)
    {
        $user_id = $request->user()->id;

        $carts = Carts::where('user_id', $user_id)->get();

        // Проверяем достаточно ли товара на складе
        foreach ($carts as $cart) {
            $product = Products::find($cart->product_id);
            if ($product->quantity < $cart->quantity) {
                return response()->json(['error' => 'Недостаточно товара на складе'], 400);
            }
        }

        // Создаем новый заказ
        $order = new Order;
        $order->user_id = $user_id;
        $order = new Order(['user_id' => $user_id, 'address' => 'Your Address']);
        $order->save();

        // Создаем детали заказа и обновляем количество товара
        foreach ($carts as $cart) {
            $product = Products::find($cart->product_id);

            // Создаем новый объект OrderList
            $orderList = new OrderList;
            $orderList->order_id = $order->id;
            $orderList->product_id = $cart->product_id;
            $orderList->quantity = $cart->quantity;
            $orderList->price = $product->price;
            $orderList->save();

            // Обновляем количество товара в таблице products
            $product->quantity -= $cart->quantity;
            $product->save();
        }

        // Удаляем товары из корзины
        Carts::where('user_id', $user_id)->delete();

        // Возвращаем ответ с сообщением об успешном оформлении заказа
        return response()->json(['message' => 'Заказ успешно оформлен'], 200);
    }
}
