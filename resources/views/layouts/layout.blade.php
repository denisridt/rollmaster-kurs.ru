<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body style="background-color: black; color: white">
<div class="head">
    <header>
        <div class="div1">
            @auth <!-- Проверяем, аутентифицирован ли пользователь -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Выход</button>
            </form>
            @else
                @if (!request()->is('login', 'register')) <!-- Проверяем, не находится ли пользователь на странице login или register -->
                <button onclick="location.href='{{ route('login') }}'">login</button>
                @endif
            @endauth
        </div>

        <div class="div2">
            <a href="{{ route('main') }}"><img src="/public/images/logo.png" alt="logo"></a>
        </div>

        <div class="div3">
            <button>корзина</button>
        </div>
    </header>
    <nav class="navigation">
        @auth
            @if (auth()->user()->role_id === 2)
                <!-- Если пользователь администратор, перенаправляем его на страницу main -->
                <a href="{{ route('admin') }}">Панель администратора</a>
            @elseif (auth()->user()->role_id === 1)
                <!-- Если пользователь не администратор, выводим сообщение об ошибке -->
                <span onclick="alert('Вы не администратор. Доступ закрыт.')">Панель администратора</span>
            @endif
        @else
            <!-- Если пользователь не авторизован, выводим сообщение о необходимости авторизации -->
            <span onclick="alert('Пожалуйста, авторизуйтесь для доступа к панели администратора.')">Панель администратора</span>
        @endauth
        <a href="{{ route('category.index') }}" style="cursor: pointer">категории</a>
    </nav>
</div>

<div class="content" style="margin: 10px auto; padding: 20px; box-sizing: border-box">
    @yield('content')
</div>

<footer>
    <div class="description">
        ROLLMASTER - это выгодные суши в городе Томск. Покупая нашу продукцию, Вы покупаете роллы ресторанного качества по низким ценам. Вы получаете ответ на известный вопрос, чтобы такого вкусного покушать.<br>
        Вы приобретаете дополнительное время для себя и своей семьи, которое бесценно и безвозвратно. Долой ожоги и страдания на кухне.
    </div>
</footer>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smoothscroll/1.4.10/SmoothScroll.min.js" integrity="sha256-huW7yWl7tNfP7lGk46XE+Sp0nCotjzYodhVKlwaNeco=" crossorigin="anonymous"></script>
<script>
    SmoothScroll({
        // Время скролла 400 = 0.4 секунды
        animationTime    : 800,
        // Размер шага в пикселях
        stepSize         : 75,
        // Дополнительные настройки:
        // Ускорение
        accelerationDelta : 37,
        // Максимальное ускорение
        accelerationMax   : 2,
        // Поддержка клавиатуры
        keyboardSupport   : true,
        // Шаг скролла стрелками на клавиатуре в пикселях
        arrowScroll       : 50,
    })
</script>
