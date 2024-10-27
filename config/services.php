<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Сервисы сторонних разработчиков
    |--------------------------------------------------------------------------
    |
    | Этот файл предназначен для хранения данных аутентификации сторонних
    | сервисов, таких как Mailgun, Postmark, AWS и другие. Он предоставляет
    | стандартное место для хранения таких данных, что упрощает их использование.
    |
    */

    // Настройки для Postmark
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'), // Токен API для Postmark
    ],

    // Настройки для Amazon SES (Simple Email Service)
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'), // Ключ доступа AWS
        'secret' => env('AWS_SECRET_ACCESS_KEY'), // Секретный ключ AWS
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'), // Регион AWS
    ],

    // Настройки для Resend
    'resend' => [
        'key' => env('RESEND_KEY'), // Ключ API для сервиса Resend
    ],

    // Настройки для Slack (уведомления)
    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'), // OAuth токен для Slack бота
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'), // Канал по умолчанию для отправки уведомлений
        ],
    ],

];
