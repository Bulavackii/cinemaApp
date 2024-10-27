<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Запускает посев данных для создания или обновления администратора.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            // Проверка на существующий email
            ['email' => 'admin@example.com'],
            [
                'name' => 'admin',
                // Пароль должен быть захеширован
                'password' => Hash::make('111'), // Захешированный пароль
                'role' => 'admin', // Установка роли администратора
            ]
        );
    }
}
