<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;

    protected $table = 'seances'; // Соответствие с таблицей
    protected $fillable = [
        'cinema_hall_id',
        'movie_id',
        'start_time',
        'end_time',
        'price_regular',
        'price_vip',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Связь с фильмом.
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Связь с кинозалом.
     */
    public function cinemaHall()
    {
        return $this->belongsTo(CinemaHall::class);
    }

    /**
     * Связь с билетами.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Форматирование времени начала.
     */
    public function getFormattedStartTimeAttribute()
    {
        return $this->start_time ? $this->start_time->format('d.m.Y H:i') : null;
    }

    /**
     * Форматирование времени окончания.
     */
    public function getFormattedEndTimeAttribute()
    {
        return $this->end_time ? $this->end_time->format('d.m.Y H:i') : null;
    }

    /**
     * Проверка доступности сеанса для бронирования.
     */
    public function isAvailable()
    {
        return $this->end_time > now();
    }
}
