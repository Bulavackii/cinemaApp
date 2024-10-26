<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinemaHall extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rows',
        'seats_per_row',
        'is_active',
    ];

    /**
     * Отношение "Зал имеет много сеансов".
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seances()
    {
        return $this->hasMany(Seance::class);
    }

    /**
     * Активация зала.
     */
    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    /**
     * Деактивация зала.
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    /**
     * Проверка, активен ли зал.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }
}
