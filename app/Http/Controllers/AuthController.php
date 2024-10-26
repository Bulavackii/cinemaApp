<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('client.index');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Валидация входных данных
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Проверка количества попыток входа
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return back()->withErrors([
                'email' => 'Слишком много попыток входа. Пожалуйста, попробуйте позже.'
            ])->onlyInput('email');
        }

        // Попытка аутентификации
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            RateLimiter::clear($this->throttleKey($request));

            // Перенаправление в зависимости от роли пользователя
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin');
            }

            return redirect()->intended('/');
        }

        // Увеличение счетчика попыток входа
        RateLimiter::hit($this->throttleKey($request));

        // Возврат ошибки, если учетные данные неверные
        return back()->withErrors([
            'email' => 'Неправильные учетные данные.'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function throttleKey(Request $request)
    {
        return strtolower($request->input('email')) . '|' . $request->ip();
    }
}