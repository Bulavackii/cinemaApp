<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Processor\PsrLogMessageProcessor;

return [

    /*
    |--------------------------------------------------------------------------
    | Канал логирования по умолчанию
    |--------------------------------------------------------------------------
    |
    | Эта опция определяет канал логирования, который будет использоваться
    | по умолчанию для записи сообщений в логи. Значение должно соответствовать
    | одному из каналов, настроенных в разделе "channels" ниже.
    |
    */
    'default' => env('LOG_CHANNEL', 'stack'), // Канал логирования по умолчанию ('stack')

    /*
    |--------------------------------------------------------------------------
    | Канал логирования для устаревших функций
    |--------------------------------------------------------------------------
    |
    | Эта опция контролирует канал логирования для записи предупреждений
    | о устаревших функциях PHP и библиотек. Это позволяет подготовить
    | приложение к будущим версиям зависимостей.
    |
    */
    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'), // Канал для логирования устаревших функций
        'trace' => env('LOG_DEPRECATIONS_TRACE', false), // Включить или отключить трассировку
    ],

    /*
    |--------------------------------------------------------------------------
    | Каналы логирования
    |--------------------------------------------------------------------------
    |
    | Здесь вы можете настроить каналы логирования для вашего приложения.
    | Laravel использует библиотеку Monolog, которая поддерживает множество
    | обработчиков и форматтеров для логирования.
    |
    | Поддерживаемые драйверы: "single", "daily", "slack", "syslog",
    |                          "errorlog", "monolog", "custom", "stack"
    |
    */
    'channels' => [

        // "stack" объединяет несколько каналов в один
        'stack' => [
            'driver' => 'stack',
            'channels' => explode(',', env('LOG_STACK', 'single')), // Каналы, включаемые в "stack"
            'ignore_exceptions' => false, // Игнорировать исключения или нет
        ],

        // "single" записывает все в один файл логов
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'), // Путь к файлу логов
            'level' => env('LOG_LEVEL', 'debug'), // Уровень логирования по умолчанию
            'replace_placeholders' => true, // Заменять плейсхолдеры в логах
        ],

        // "daily" создает новый файл логов каждый день
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => env('LOG_DAILY_DAYS', 14), // Количество дней для хранения логов
            'replace_placeholders' => true,
        ],

        // Логирование в Slack через webhook
        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'), // URL вебхука Slack
            'username' => env('LOG_SLACK_USERNAME', 'Laravel Log'), // Имя отправителя логов
            'emoji' => env('LOG_SLACK_EMOJI', ':boom:'), // Эмодзи для сообщений
            'level' => env('LOG_LEVEL', 'critical'), // Логировать только критические ошибки
            'replace_placeholders' => true,
        ],

        // Логирование через Papertrail
        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => env('LOG_PAPERTRAIL_HANDLER', SyslogUdpHandler::class),
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),  // URL для подключения
                'port' => env('PAPERTRAIL_PORT'), // Порт подключения
                'connectionString' => 'tls://'.env('PAPERTRAIL_URL').':'.env('PAPERTRAIL_PORT'), // Строка подключения с использованием TLS
            ],
            'processors' => [PsrLogMessageProcessor::class], // Обработчик для форматирования сообщений
        ],

        // Логирование в стандартный поток ошибок (stderr)
        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class, // Используем StreamHandler для stderr
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr', // Запись в поток ошибок
            ],
            'processors' => [PsrLogMessageProcessor::class], // Процессор для сообщений
        ],

        // Логирование через системный журнал (syslog)
        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
            'facility' => env('LOG_SYSLOG_FACILITY', LOG_USER), // Категория системного журнала
            'replace_placeholders' => true,
        ],

        // Логирование через стандартный обработчик ошибок PHP (errorlog)
        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],

        // Канал "null" игнорирует все логи (для отключения логирования)
        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class, // Обработчик, который ничего не делает
        ],

        // Аварийный канал логирования
        'emergency' => [
            'path' => storage_path('logs/laravel.log'), // Путь к файлу логов для аварийных сообщений
        ],

    ],

];
