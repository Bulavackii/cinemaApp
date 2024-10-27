<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Контроллер регистрации
    |--------------------------------------------------------------------------
    |
    | Этот контроллер обрабатывает регистрацию новых пользователей, а также их
    | валидацию и создание. По умолчанию контроллер использует трейт для
    | предоставления этой функциональности без необходимости дополнительного кода.
    |
    */

    use RegistersUsers; // Трейт для обработки регистрации и входа новых пользователей

    /**
     * Куда перенаправлять пользователей после успешной регистрации.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Перенаправление на главную страницу после регистрации

    /**
     * Создание нового экземпляра контроллера.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware "guest" разрешает доступ только для гостей, неавторизованных пользователей
        $this->middleware('guest');
    }

    /**
     * Получить валидатор для входящего запроса на регистрацию.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // Валидация данных регистрации: имя, email и пароль
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'], // Имя пользователя обязательно и не длиннее 255 символов
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Email обязательно должен быть уникальным
            'password' => ['required', 'string', 'min:3', 'confirmed'], // Пароль обязательно минимум 3 символа и должен быть подтвержден
        ]);
    }

    /**
     * Создать нового пользователя после успешной валидации.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Создание нового пользователя с захешированным паролем
        return User::create([
            'name' => $data['name'], // Имя пользователя
            'email' => $data['email'], // Email пользователя
            'password' => Hash::make($data['password']), // Хеширование пароля перед сохранением
        ]);
    }
}
