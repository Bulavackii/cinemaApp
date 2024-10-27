<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// Базовый контроллер, от которого наследуются другие контроллеры
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests; // Трейты для авторизации и валидации

    /*
     |--------------------------------------------------------------------------
     | Контроллер по умолчанию
     |--------------------------------------------------------------------------
     |
     | Этот контроллер предоставляет базовые функциональные возможности
     | для всех контроллеров, такие как авторизация и валидация запросов.
     | Трейты AuthorizesRequests и ValidatesRequests добавляют необходимые
     | методы для упрощения работы с этими задачами.
     |
     */
}
