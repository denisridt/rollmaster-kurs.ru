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
    public function create(CategoryCreateRequest $request){
        $category = new Categories($request->all());
        $category->save();
        return response()->json($category)->setStatusCode(200 , 'Успешно');
    }

    public function show($id){
        $categories = Categories::findOrFail($id);
        $products = $categories->products;
        return view('category.show', compact('categories', 'products'));
    }

    public function update(CategoryUpdateRequest $request, $id){
        $category = Categories::find($id);
        if($category){
            $category->update($request->all());
            return response()->json($category)->setStatusCode(200 , 'Успешно');
        }else{
            return response()->json('Категория не найдена')->setStatusCode(404 , 'Не найдено');
        }
    }
    public function destroy($id){
        $category = Categories::find($id);
        if($category){
            Categories::destroy($id);
            return response()->json('Категория удалена')->setStatusCode(200 , 'Успешно');

        }else{
            return response()->json('Категория не найдена')->setStatusCode(404 , 'Не найдено');
        }
    }

}
