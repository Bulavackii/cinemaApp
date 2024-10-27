<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    // Указываем поля, которые могут быть заполнены массово
    protected $fillable = [
        'title',        // Название фильма
        'description',  // Описание фильма
        'country',      // Страна производства
        'genre',        // Жанр фильма
        'duration',     // Длительность фильма (в минутах)
        'poster_url',   // URL постера фильма
    ];

    /**
     * Связь "Фильм имеет много сеансов".
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seances()
    {
        // Фильм может иметь множество сеансов
        return $this->hasMany(Seance::class);
    }
}
