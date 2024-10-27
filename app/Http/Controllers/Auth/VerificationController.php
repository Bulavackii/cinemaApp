<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Контроллер проверки электронной почты
    |--------------------------------------------------------------------------
    |
    | Этот контроллер отвечает за обработку верификации email для пользователей,
    | которые недавно зарегистрировались в приложении. Также можно повторно
    | отправить письмо, если пользователь не получил его изначально.
    |
    */

    use VerifiesEmails; // Трейт для обработки верификации email

    /**
     * Куда перенаправлять пользователей после успешной верификации.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Перенаправление на главную страницу после верификации

    /**
     * Создание нового экземпляра контроллера.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware 'auth' гарантирует, что только авторизованные пользователи могут проходить верификацию
        $this->middleware('auth');
        
        // Middleware 'signed' проверяет, что запрос на верификацию был подписан корректной ссылкой
        $this->middleware('signed')->only('verify');

        // Middleware 'throttle' ограничивает количество попыток верификации: не более 6 попыток за минуту
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
