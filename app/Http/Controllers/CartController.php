<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function viewCart()
    {
        $user_id = auth()->id(); // Assuming you have authentication set up
        $cartItems = Carts::where('user_id', $user_id)->get();

        return view('cart/cart', ['cartItems' => $cartItems]);
    }
    public function addItem(Request $request, $id)
    {
        // Получаем данные из запроса
        $quantity = $request->input('quantity');

        // Получаем информацию о товаре
        $product = Products::findOrFail($id);


        // Вычисляем стоимость за один товар
        $itemPrice = $product->price;

        // Получаем идентификатор текущего пользователя
        $userId = Auth::id();

        // Создаем новую запись в таблице carts
        $cartItem = new Carts();
        $cartItem->user_id = $userId; // Устанавливаем user_id
        $cartItem->product_id = $id;
        $cartItem->quantity = $quantity;

        // Сохраняем запись
        $cartItem->save();

        // Возвращаем ответ в виде JSON
        return response()->json(['message' => 'Item added to cart successfully', 'total_price' => $cartItem->price]);
    }
}
