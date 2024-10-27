<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Засевает базу данных приложения.
     */
    public function run(): void
    {
        // Этот код создает 10 случайных пользователей с помощью фабрики 
        // User::factory(10)->create();

        // Создание конкретного пользователя с определенными данными
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
