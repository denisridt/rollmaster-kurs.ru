<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function  index(){
        $product = Products::all();
        return response()->json($product)->setStatusCode(200 , 'Успешно');
    }
    /*
    public function addToCart(Request $request, $id) {
        $product = Product::where('id', $id)->first();
        //проверка на существование товара
        if(!$product) {
            return response()->json(['error' => 'Продукт не найден'], 404);
        }
        //получаем текущего пользователя
        $user = auth()->user();

        //проверка существует ли пользователь
        if (!$user) {
            return response()->json(['error' => 'Пользователь не авторизирован'], 401);
        }
        // Получаем количество товара из запроса (добавляем еще значения по умолчанию = 1)
        $quantity = $request->input('quantity', 1);

        // Проверяем, что количество товара больше 0
        if ($quantity <= 0) {
            return response()->json(['error' => 'Количество товара должно быть больше 0'], 400);
        }

        $cartItem = new Cart([
           'quantity' => $quantity,
            'price' => $product->price * $quantity,
            'product_id' => $product->id,
        ]);
        //связываем товар с пользователем и сохраняем в БД
        $user->cart()->save($cartItem);

        return response()->json(['message' => 'Продукт добавлен в корзинку']);
    }
*/
    public function create(ProductCreateRequest $request){
        $product = new Product($request->all());
        $product->save();
        return response()->json($product)->setStatusCode(200 , 'Успешно');
    }

    public function update(ProductUpdateRequest $request, $id){
        $product = Product::find($id);
        if($product){
            $product->update($request->all());
            return response()->json($product)->setStatusCode(200 , 'Успешно');
        }else{
            return response()->json('Продукт не найден')->setStatusCode(404 , 'Не найдено');
        }
    }
}
