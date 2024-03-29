@extends('layouts.layout-admin')
@section('title', 'Admin-Panel')

@section('content')
    <h1>Категории |<a style="cursor: pointer"> cоздать</a></h1>
    <div class="category-list">
        @foreach ($categories as $category)
            <div class="category-item">
                <p>ID: {{ $category->id }}</p>
                <p>Название: {{ $category->name }} |</p>
                <a class="edit-a">Изменить</a>
                <a class="delete-a">Удалить</a>
            </div>
        @endforeach
    </div>
@endsection

<style>
    .category-list{
        margin: auto 0;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: 1fr;
        grid-column-gap: 0;
        grid-row-gap: 0;
    }
    .category-item{
        margin: 5px;
        padding: 5px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: grey solid 2px;
        border-radius: 8px;
    }
    .delete-a:hover{
        color: red;
        cursor: pointer;
    }
    .edit-a:hover{
        color: orange;
        cursor: pointer;
    }
</style>
