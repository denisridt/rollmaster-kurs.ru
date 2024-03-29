@extends('layouts.layout')

@section('title', 'Product Page')

@section('content')
        <div class="product-details">
            <div style="border: #FFF500 3px solid; margin: 20px; border-radius: 5px; padding: 5px">
                <img src="{{ $product->photo }}" alt="{{ $product->name }}">
            </div>
            <div class="product-details-text">
                <h1>{{ $product->name }}</h1>
                <p style="max-width: 300px;">{{ $product->description }}</p>
                <p>Цена: {{ $product->price }}p.</p>
                <p>Количество: {{ $product->amount }}</p>
                <p>Вес: {{ $product->gram }}</p>
                <button type="submit" class="button-buy">Купить</button>
            </div>
        </div>
@endsection
<style>
    .product-details{
        display: flex;
        justify-content: center;
        align-content: center;
        align-items: center;
    }
    .product-details-text{
        flex-direction: column;
    }
</style>
