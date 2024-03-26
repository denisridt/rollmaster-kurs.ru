<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $cartItems = $user->cart;

        return response()->json(['cart_items' => $cartItems]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Получаем product_id и новое количество товара из запроса
        $productId = $request->input('product_id');
        $newQuantity = $request->input('quantity');

        // Находим товар в корзине текущего пользователя по product_id
        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Товар не найден в вашей корзине'], 404);
        }

        // Проверяем, чтобы новое количество было положительным числом
        if ($newQuantity > 0) {
            $cartItem->quantity = $newQuantity;
            $cartItem->save();

            return response()->json(['message' => 'Количество товара в корзине успешно обновлено'], 200);
        } else {
            return response()->json(['error' => 'Количество товара должно быть положительным числом'], 400);
        }
    }


    public function addToCart(Request $request, $id) {
        $product = Products::where('id', $id)->first();
        if(!$product) {
            return response()->json(['error' => 'Продукт не найден'], 404);
        }
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Пользователь не авторизирован'], 401);
        }

        $quantity = $request->input('quantity', 1);


        if ($quantity <= 0) {
            return response()->json(['error' => 'Количество товара должно быть больше 0'], 400);
        }

        $cartItem = new Cart([
            'quantity' => $quantity,
            'price' => $product->price * $quantity,
            'product_id' => $product->id,
        ]);
        $user->cart()->save($cartItem);

        return response()->json(['message' => 'Продукт добавлен в корзинку']);
    }
}
