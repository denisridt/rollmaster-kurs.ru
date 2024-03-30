@extends('layouts.layout-admin')
@section('title', 'Update-Product')

@section('title', 'Изменение продукта')

@section('content')
    <h1>Изменение продукта</h1>

    <form action="{{ route('product.update', $product->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div>
            <label for="name">Название</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
        </div>
        <div>
            <label for="description">Описание</label>
            <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
        </div>
        <div>
            <label for="price">Цена</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
        </div>
        <div>
            <label for="amount">Количество</label>
            <input type="number" class="form-control" id="amount" name="amount" value="{{ $product->amount }}" required>
        </div>
        <div>
            <label for="gram">gram</label>
            <input type="text" id="amount" name="gram" value="{{ $product->gram }}" required>
        </div>
        <div>
            <label for="photo">Photo</label>
            @if ($product->photo)
                <img style="max-width: 20%" src="{{ asset($product->photo) }}" alt="Current Photo">
            @endif
            <input type="file" id="photo" name="photo">
        </div>
        <div>
            <label for="category_id">Category</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">Select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Добавьте другие поля для изменения информации о продукте, если необходимо -->
        <button type="submit">Сохранить изменения</button>
    </form>
@endsection
