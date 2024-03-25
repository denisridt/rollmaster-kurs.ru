<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Exceptions\AoiException;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('number', 'password');

        if (Auth::attempt($credentials)) {
            // Аутентификация прошла успешно
            $user = Auth::user();
            $user->api_token = bcrypt(microtime(true)); // Генерируем новый API токен для пользователя
            $user->save();

            // Выводим сообщение в консоль

            return redirect('/main');
        } else {
            // Аутентификация не удалась
            return redirect()->back()->with('error', 'Неправильный номер телефона или пароль');
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Разлогиниваем пользователя
        return redirect('/main'); // Перенаправляем на домашнюю страницу
    }
    public function register(Request $request)
    {
        // Создаем нового пользователя с предоставленными данными
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'login' => $request->login,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'number' => $request->number,
        ]);


        // Перенаправляем на страницу входа с сообщением об успешной регистрации
        return redirect('/login')->with('success', 'Вы успешно зарегистрированы. Войдите в систему.');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }
}
