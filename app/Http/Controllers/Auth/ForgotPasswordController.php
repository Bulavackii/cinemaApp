<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Контроллер сброса пароля
    |--------------------------------------------------------------------------
    |
    | Этот контроллер отвечает за обработку запросов на сброс пароля и
    | использует трейт, который помогает отправлять уведомления о сбросе
    | пароля пользователям. Ты можешь изменить или расширить этот трейт.
    |
    */

    use SendsPasswordResetEmails; // Трейт для отправки уведомлений на email с инструкциями по сбросу пароля
}