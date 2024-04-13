<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Carts;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function  index(){
        $products = Products::all();

        return response(['data' => $products]);
    }

    public function show($id)
    {
        $products = Products::find($id);
        if (!$products) {
            throw new ApiException(404, 'Товар не найден');
        }
        return response(['data' => $products]);
    }

    public function create(ProductCreateRequest $request)
    {
        // Загрузка файла изображения
        $imageName = time() . '.' . $request->photo->extension();


        // Создание нового товара в базе данных
        $products = new Products($request->all());
        $products->photo = 'storage/images/products/' . $imageName; // Путь до загруженного изображения
        $products->save();
        $request->photo->move(public_path('storage/images/products/'), $imageName);

        return response()->json(['message' => 'Товар успешно создан'], 201);
    }
    public function destroy($id){
        $product = Products::find($id);
        if (!$product) {
            throw new ApiException(404, 'Продукт не найден');
        }
        $product->delete();
        return response()->json(['message' => 'Продукт успешно удален'], 200);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        // Поиск продукта по id
        $products = Products::find($id);
        if (!$products) {
            throw new ApiException(404, 'Товар не найден');
        }
        // Проверяем, есть ли продукт с таким именем уже в базе данных
        $existingProduct = Products::where('name', $request->input('name'))->first();
        if ($existingProduct) {
            throw new ApiException(422, 'Продукт с таким именем уже существует');
        }
        // Если файл был загружен, сохраняем его и обновляем путь к фото
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $imageName = time() . '.' . $photo->getClientOriginalExtension();

            $photo->storeAs('public/images/products', $imageName);
            $products->photo =  'storage/images/products/' . $imageName;
        }
        $products->fill($request->except('photo'));

        // Сохранение изменений в базе данных
        $products->save();

        // Перенаправление на страницу продукта с сообщением об успехе
        return response()->json(['message' => 'Продукт успешно обновлен'], 200);
    }

}
