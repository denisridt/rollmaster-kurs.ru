@extends('layouts.layout-auth')

@section('title', 'Login')

@section('content')
    <h1>Авторизация</h1>
    <form action="{{ route('login') }}" method="POST" action="">
        @csrf
        <div style="margin-bottom: 10px">
            <label for="number">Номер телефона:</label><br>
            <input type="text" id="number" name="number"><br>
        </div>
        <div style="margin-bottom: 10px">
            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password"><br>
        </div>
        <button style="margin-top: 10px" type="submit">Авторизация</button>
    </form>
    <a style="margin-top: 10px; text-decoration: none" href="{{ route('register') }}">Регистрация</a>
@endsection
