<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Подключение к базе данных по умолчанию
    |--------------------------------------------------------------------------
    |
    | Здесь вы можете указать, какое подключение к базе данных будет использоваться
    | по умолчанию для операций с базой данных. Это подключение будет использовано,
    | если не указано другое при выполнении запроса или операции.
    |
    */
    'default' => env('DB_CONNECTION', 'sqlite'), // Подключение к базе данных по умолчанию

    /*
    |--------------------------------------------------------------------------
    | Подключения к базам данных
    |--------------------------------------------------------------------------
    |
    | Здесь определяются все подключения к базам данных для вашего приложения.
    | Пример конфигурации предоставлен для каждой базы данных, поддерживаемой
    | Laravel. Вы можете добавить или удалить подключения по мере необходимости.
    |
    */

    'connections' => [

        // Подключение SQLite
        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '', // Префикс для всех таблиц (не используется по умолчанию)
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true), // Включение внешних ключей
            'busy_timeout' => null, // Время ожидания занятых операций
            'journal_mode' => null, // Режим журнала операций
            'synchronous' => null, // Синхронный режим
        ],

        // Подключение MySQL
        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),  // Хост для подключения к базе данных
            'port' => env('DB_PORT', '3306'),      // Порт для подключения к MySQL
            'database' => env('DB_DATABASE', 'laravel'), // Название базы данных
            'username' => env('DB_USERNAME', 'root'),   // Имя пользователя
            'password' => env('DB_PASSWORD', ''),       // Пароль
            'unix_socket' => env('DB_SOCKET', ''),      // Использование Unix-сокета (если требуется)
            'charset' => env('DB_CHARSET', 'utf8mb4'),  // Кодировка
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'), // Сортировка
            'prefix' => '',         // Префикс таблиц
            'prefix_indexes' => true, // Индексация с учетом префикса
            'strict' => true,       // Включение строгого режима MySQL
            'engine' => null,       // Движок таблиц (InnoDB по умолчанию)
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'), // Опции SSL
            ]) : [],
        ],

        // Подключение MariaDB
        'mariadb' => [
            'driver' => 'mariadb',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        // Подключение PostgreSQL
        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'), // Кодировка для PostgreSQL
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public', // Пути поиска для схем
            'sslmode' => 'prefer', // SSL-режим (может быть 'disable', 'require', 'verify-full')
        ],

        // Подключение SQL Server
        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Таблица миграций
    |--------------------------------------------------------------------------
    |
    | Эта таблица отслеживает все миграции, которые уже были выполнены для
    | вашего приложения. Используя эту информацию, можно определить, какие
    | миграции еще не были выполнены на базе данных.
    |
    */
    'migrations' => [
        'table' => 'migrations',  // Таблица для миграций
        'update_date_on_publish' => true, // Обновление даты при публикации миграции
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis
    |--------------------------------------------------------------------------
    |
    | Redis — это быстрая и мощная система ключ-значение, которая также предоставляет
    | богатый набор команд. Здесь вы можете настроить подключение к Redis.
    |
    */
    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'), // Клиент Redis по умолчанию

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'), // Опция кластера для Redis
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'), // Префикс для ключей Redis
        ],

        // Основная база данных Redis
        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        // База данных Redis для кеша
        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
