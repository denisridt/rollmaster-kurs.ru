@extends('layouts.layout')

@section('title', 'Register')

@section('content')

        <h1>Регистрация</h1>
        <form action="{{ route('register') }}" method="POST" action="">
            @csrf
            <label for="name">Имя:</label><br>
            <input type="text" id="name" name="name" value="{{ old('name') }}"><br>
            <label for="login">Логин:</label><br>
            <input type="text" id="login" name="login" value="{{ old('login') }}"><br>
            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password" value="{{ old('password') }}"><br>
            <label for="email">Почта:</label><br>
            <input type="email" id="email" name="email" value="{{ old('email') }}"><br>
            <label for="number">Номер телефона:</label><br>
            <input type="text" id="number" name="number" value="{{ old('number') }}"><br>
            <button style="margin-top: 10px" type="submit">Регистрация</button>
        </form>
        <a style="margin-top: 10px; text-decoration: none" href="{{ route('login') }}">Авторизация</a>


@endsection
