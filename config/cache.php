<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Кеш по умолчанию
    |--------------------------------------------------------------------------
    |
    | Эта опция контролирует хранилище кеша, которое будет использоваться по
    | умолчанию в приложении. Если при выполнении операции с кешем не указано
    | другое хранилище, будет использоваться указанное здесь.
    |
    */
    'default' => env('CACHE_STORE', 'database'), // Хранилище кеша по умолчанию (использует 'database')

    /*
    |--------------------------------------------------------------------------
    | Хранилища кеша
    |--------------------------------------------------------------------------
    |
    | Здесь вы можете определить все "хранилища" кеша для вашего приложения,
    | а также их драйверы. Вы можете даже определить несколько хранилищ для
    | одного и того же драйвера кеша, чтобы сгруппировать типы элементов.
    |
    | Поддерживаемые драйверы: "array", "database", "file", "memcached",
    |                          "redis", "dynamodb", "octane", "null"
    |
    */
    'stores' => [

        // Хранилище на основе массива (данные не сохраняются между запросами)
        'array' => [
            'driver' => 'array',
            'serialize' => false,  // Опция для сериализации данных в массиве
        ],

        // Хранилище на основе базы данных
        'database' => [
            'driver' => 'database',
            'connection' => env('DB_CACHE_CONNECTION'),  // Подключение к базе данных для кеша
            'table' => env('DB_CACHE_TABLE', 'cache'),   // Таблица для хранения данных кеша
            'lock_connection' => env('DB_CACHE_LOCK_CONNECTION'), // Подключение для блокировок
            'lock_table' => env('DB_CACHE_LOCK_TABLE'),  // Таблица для блокировок
        ],

        // Хранилище на основе файловой системы
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'), // Путь для хранения файлов кеша
            'lock_path' => storage_path('framework/cache/data'), // Путь для блокировок кеша
        ],

        // Хранилище на основе Memcached
        'memcached' => [
            'driver' => 'memcached',
            'persistent_id' => env('MEMCACHED_PERSISTENT_ID'), // Идентификатор для постоянного соединения
            'sasl' => [ // Настройки SASL для аутентификации
                env('MEMCACHED_USERNAME'),
                env('MEMCACHED_PASSWORD'),
            ],
            'options' => [
                // Опции Memcached (например, время ожидания подключения)
                // Memcached::OPT_CONNECT_TIMEOUT => 2000,
            ],
            'servers' => [ // Серверы Memcached
                [
                    'host' => env('MEMCACHED_HOST', '127.0.0.1'), // Хост Memcached
                    'port' => env('MEMCACHED_PORT', 11211),        // Порт Memcached
                    'weight' => 100,                               // Вес сервера
                ],
            ],
        ],

        // Хранилище на основе Redis
        'redis' => [
            'driver' => 'redis',
            'connection' => env('REDIS_CACHE_CONNECTION', 'cache'), // Подключение к Redis
            'lock_connection' => env('REDIS_CACHE_LOCK_CONNECTION', 'default'), // Подключение для блокировок Redis
        ],

        // Хранилище на основе DynamoDB
        'dynamodb' => [
            'driver' => 'dynamodb',
            'key' => env('AWS_ACCESS_KEY_ID'),         // Ключ доступа AWS
            'secret' => env('AWS_SECRET_ACCESS_KEY'),  // Секретный ключ AWS
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'), // Регион AWS
            'table' => env('DYNAMODB_CACHE_TABLE', 'cache'),    // Таблица для кеша в DynamoDB
            'endpoint' => env('DYNAMODB_ENDPOINT'),    // Точка подключения DynamoDB
        ],

        // Хранилище для Octane (ускоренная обработка)
        'octane' => [
            'driver' => 'octane',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Префикс для ключей кеша
    |--------------------------------------------------------------------------
    |
    | При использовании таких драйверов, как APC, база данных, Memcached, Redis и DynamoDB,
    | другие приложения могут использовать то же самое хранилище кеша. Чтобы избежать
    | конфликтов, можно задать префикс для каждого ключа кеша.
    |
    */
    'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_cache_'), // Префикс для ключей кеша

];
