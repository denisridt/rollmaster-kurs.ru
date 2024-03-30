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
        $categories = Categories::findOrFail($id);
        $products = $categories->products;
        return view('category.show', compact('categories', 'products'));
    }
    public function showFormCreateCategory()
    {
        $categories = Categories::all();
        return view('category.create')->with('categories', $categories);
    }

    // Сохранение нового товара в базе данных
    public function create(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|min:1|max:255',
            'photo'       => 'nullable|file|mimes:jpeg,jpg,png,webp|max:4096',
        ]);

        // Загрузка файла изображения
        $imageName = time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('images'), $imageName);

        // Создание нового товара в базе данных
        $categories = new Categories();
        $categories->name = $request->name;
        $categories->photo = 'images/' . $imageName; // Путь до загруженного изображения
        $categories->save();

        return redirect()->route('admin.categories')->with('success', 'Категория успешно создана.');
    }
    public function destroy($id){
        $categories = Categories::find($id);
        $categories->delete();
        return redirect()->back();
    }
}
