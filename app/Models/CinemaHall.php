<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinemaHall extends Model
{
    use HasFactory;

    // Указываем поля, которые могут быть заполнены массово
    protected $fillable = [
        'name',            // Название зала
        'rows',            // Количество рядов
        'seats_per_row',   // Количество мест в каждом ряду
        'is_active',       // Статус активации зала (активен или нет)
    ];

    /**
     * Связь "Зал имеет много сеансов".
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seances()
    {
        // Зал может иметь множество сеансов
        return $this->hasMany(Seance::class);
    }

    /**
     * Активация зала.
     * Обновляет статус зала на "активен".
     */
    public function activate()
    {
        // Устанавливаем статус активации на true
        $this->update(['is_active' => true]);
    }

    /**
     * Деактивация зала.
     * Обновляет статус зала на "неактивен".
     */
    public function deactivate()
    {
        // Устанавливаем статус активации на false
        $this->update(['is_active' => false]);
    }

    /**
     * Проверка, активен ли зал.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        // Возвращает текущий статус активации зала
        return $this->is_active;
    }
}
