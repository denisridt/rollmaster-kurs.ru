@extends('layouts.layout')

@section('title', 'Create Product Page')

@section('content')
                    <h1 style="text-align: center">Новый продукт</h1>
                    <div style="display: flex; justify-content: center">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('product.create') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="gram">gram</label>
                                <input type="text" class="form-control" id="gram" name="gram" value="{{ old('gram') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <input type="file" id="photo" name="photo">
                            </div>

                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit">Добавить</button>
                        </form>
                    </div>
@endsection

