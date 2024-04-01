<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Cart;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function  index(){
        $products = Products::all();
        $categories = Categories::all();

        return view('main', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Products::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Продукт не найден');
        }
        return view('product.show', ['product' => $product]);
    }

    public function showFormCreateProduct()
    {

        $categories = Categories::all();
        return view('product.create')->with('categories', $categories);
    }
    public function showFormUpdateProduct($id)
    {
        $categories = Categories::all();
        $product = Products::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Продукт не найден');
        }
        return view('product.update', compact('product'))->with('categories', $categories);
    }

    // Сохранение нового товара в базе данных
    public function create(Request $request)
    {

        $request->validate([
            'name'        => 'required|string|min:1|max:255',
            'description' => 'string|nullable',
            'price'       => ['required', 'numeric', 'min:0', 'regex:/^\d{1,8}(\.\d{1,2})?$/'],
            'amount'    => 'required|integer|min:1',
            'gram' => 'required|numeric|min:0',
            'photo'       => 'nullable|file|mimes:jpeg,jpg,png,webp|max:4096',
            'category_id' => 'required|integer|exists:categories,id'
        ]);
        // Загрузка файла изображения
        $imageName = time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('images/products'), $imageName);

        // Создание нового товара в базе данных
        $products = new Products();
        $products->name = $request->name;
        $products->description = $request->description;
        $products->price = $request->price;
        $products->amount = $request->amount;
        $products->photo = 'images/products/' . $imageName; // Путь до загруженного изображения
        $products->gram = $request->gram;
        $products->categories_id = $request->category_id;
        $products->save();

        return redirect()->route('admin.products')->with('success', 'Товар успешно создан.');
    }

    public function destroy($id){
        $product = Products::find($id);
        $product->delete();
        return redirect()->back();
    }

    public function update(Request $request, $id){
        if ($request->isMethod('post')) {
            Products::where('id', '=', $id)->update(
            /*
             * [
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'category_id' => $request->category_id,
            ]
             */
                $request->except('_token')
            );
            return redirect('/products');
        } else {
            $product = Products::where('id', '=', $id)->first();
            $categories = Categories::all();
            return view('product.update', ['product' => $product, 'categories' => $categories]);
        }
    }

}
