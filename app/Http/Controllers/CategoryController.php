<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Categories::all();
        return view('category.index', ['categories' => $categories]);
    }
    public function show($id){
        $category = Categories::findOrFail($id);
        $products = $category->products;
        return view('category.show', compact('category', 'products'));
    }
    public function showFormCreateCategory()
    {
        $categories = Categories::all();
        return view('category.create')->with('categories', $categories);
    }
    public function showFormUpdateCategory($id)
    {
        $categories = Categories::find($id);
        return view('category.update')->with('categories', $categories);
    }
    // Сохранение нового товара в базе данных
    public function create(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|min:1|max:255',

        ]);

        $categories = new Categories();
        $categories->name = $request->name;
        $categories->save();

        return redirect()->route('admin.categories')->with('success', 'Категория успешно создана.');
    }
    public function destroy($id){
        $categories = Categories::find($id);
        $categories->delete();
        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        // Валидация данных
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Поиск category по id
        $categories = Categories::find($id);

        if (!$categories) {
            return redirect()->back()->with('error', 'Продукт не найден');
        }

        // Обновление данных category
        $categories->name = $request->name;

        // Сохранение изменений в базе данных
        $categories->save();

        // Перенаправление на страницу продукта с сообщением об успехе
        return redirect()->route('category.update', $categories->id)->with('success', 'Продукт успешно обновлен');
    }
}
