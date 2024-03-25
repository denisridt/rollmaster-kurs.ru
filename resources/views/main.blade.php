@extends('layouts.layout')

@section('title', 'Main Page')

@section('content')
    @foreach ($categories as $category)
        <h2>{{ $category->name }}</h2>
        <div class="products">
            @foreach ($products->where('category_id', $category->id) as $product)
                <div class="product-card">
                    <h3>{{ $product->name }}</h3>
                    <p>Цена: {{ $product->price }}</p>
                    <p>amount: {{ $product->amount }}</p>
                    <img src="{{ $product->photo }}" alt="{{ $product->name }}">
                </div>
            @endforeach
        </div>
    @endforeach
@endsection
