<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Создает новый экземпляр контроллера.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Отображает панель управления.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Проверяем роль пользователя
        $user = Auth::user();

        // Логика для перенаправления администраторов на админскую панель
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        }

        // Логика для обычных пользователей
        return view('home', compact('user'));
    }
}
