<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Текущий пароль, используемый фабрикой.
     * Этот статический атрибут сохраняет пароль между вызовами фабрики, чтобы
     * каждый раз не генерировать новый захешированный пароль для пользователей.
     */
    protected static ?string $password;

    /**
     * Определяет стандартное состояние модели User.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Генерация случайного имени
            'name' => fake()->name(),
            // Генерация уникального и безопасного email
            'email' => fake()->unique()->safeEmail(),
            // Установка текущей даты и времени для подтверждения email
            'email_verified_at' => now(),
            // Установка пароля, используя захешированное значение 'password'
            // Если пароль уже сгенерирован, будет использовано предыдущее значение
            'password' => static::$password ??= Hash::make('password'),
            // Создание случайного токена для функции "запомнить меня"
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Указывает, что email пользователя должен быть неподтвержденным.
     * Эта функция изменяет состояние модели, устанавливая `email_verified_at` в null.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
