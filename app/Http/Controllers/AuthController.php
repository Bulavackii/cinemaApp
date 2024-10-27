<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;

class AuthController extends Controller
{
    // Показ формы регистрации
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Регистрация нового пользователя
    public function register(Request $request)
    {
        // Валидация данных формы регистрации
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Email должен быть уникальным
            'password' => 'required|string|min:3|confirmed', // Пароль минимум 3 символа и подтверждение
        ]);

        // Создание нового пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Хешируем пароль перед сохранением
        ]);

        // Выполняем вход нового пользователя
        Auth::login($user);

        // Перенаправление на главную страницу клиента
        return redirect()->route('client.index');
    }

    // Показ формы входа
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Аутентификация пользователя
    public function login(Request $request)
    {
        // Валидация данных формы входа
        $credentials = $request->validate([
            'email' => 'required|email', // Проверяем наличие и корректность email
            'password' => 'required', // Пароль обязателен
        ]);

        // Проверка на превышение количества попыток входа
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return back()->withErrors([
                'email' => 'Слишком много попыток входа. Пожалуйста, попробуйте позже.'
            ])->onlyInput('email');
        }

        // Попытка аутентификации пользователя
        if (Auth::attempt($credentials)) {
            // При успешной аутентификации регенерируем сессию
            $request->session()->regenerate();
            RateLimiter::clear($this->throttleKey($request)); // Сброс счетчика попыток

            // Перенаправление в зависимости от роли пользователя
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin'); // Перенаправление для админа
            }

            return redirect()->intended('/'); // Перенаправление для обычного пользователя
        }

        // Увеличение счетчика попыток входа при неудачной попытке
        RateLimiter::hit($this->throttleKey($request));

        // Возвращаем ошибку, если учетные данные неверны
        return back()->withErrors([
            'email' => 'Неправильные учетные данные.'
        ])->onlyInput('email');
    }

    // Выход пользователя из системы
    public function logout(Request $request)
    {
        // Выполняем выход пользователя
        Auth::logout();

        // Инвалидируем сессию и регенерируем токен безопасности
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Перенаправляем на главную страницу
        return redirect('/');
    }

    // Генерация ключа для ограничения по количеству попыток входа
    protected function throttleKey(Request $request)
    {
        // Ключ формируется на основе email и IP-адреса пользователя
        return strtolower($request->input('email')) . '|' . $request->ip();
    }
}
