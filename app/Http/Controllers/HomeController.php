<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Создает новый экземпляр контроллера.
     * Применяет middleware 'auth', чтобы ограничить доступ к методам
     * только для аутентифицированных пользователей.
     */
    public function __construct()
    {
        $this->middleware('auth'); // Только авторизованные пользователи могут получить доступ к этому контроллеру
    }

    /**
     * Отображает панель управления для пользователя.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Получаем текущего авторизованного пользователя
        $user = Auth::user();

        // Проверяем роль пользователя. Если это администратор, перенаправляем на админскую панель
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }

        // Если это не администратор, показываем обычную домашнюю страницу
        return view('home', compact('user'));
    }
}
