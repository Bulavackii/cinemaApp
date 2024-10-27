<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;

    // Указываем, что эта модель связана с таблицей 'seances'
    protected $table = 'seances'; 
    
    // Поля, которые могут быть массово заполнены
    protected $fillable = [
        'cinema_hall_id',  // ID кинозала
        'movie_id',        // ID фильма
        'start_time',      // Время начала сеанса
        'end_time',        // Время окончания сеанса
        'price_regular',   // Цена за обычное место
        'price_vip',       // Цена за VIP место
    ];

    // Преобразование полей в тип datetime
    protected $casts = [
        'start_time' => 'datetime',  // Поле 'start_time' хранится как datetime
        'end_time' => 'datetime',    // Поле 'end_time' хранится как datetime
    ];

    /**
     * Связь с фильмом.
     * Один сеанс принадлежит одному фильму.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie()
    {
        // Связь "многие к одному" — один сеанс относится к одному фильму
        return $this->belongsTo(Movie::class);
    }

    /**
     * Связь с кинозалом.
     * Один сеанс проходит в одном кинозале.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cinemaHall()
    {
        // Связь "многие к одному" — один сеанс относится к одному кинозалу
        return $this->belongsTo(CinemaHall::class);
    }

    /**
     * Связь с билетами.
     * Один сеанс может иметь множество билетов.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        // Связь "один ко многим" — один сеанс может иметь множество билетов
        return $this->hasMany(Ticket::class);
    }

    /**
     * Форматирование времени начала сеанса.
     * Возвращает отформатированную строку даты и времени.
     *
     * @return string|null
     */
    public function getFormattedStartTimeAttribute()
    {
        // Если время начала установлено, форматируем его, иначе возвращаем null
        return $this->start_time ? $this->start_time->format('d.m.Y H:i') : null;
    }

    /**
     * Форматирование времени окончания сеанса.
     * Возвращает отформатированную строку даты и времени.
     *
     * @return string|null
     */
    public function getFormattedEndTimeAttribute()
    {
        // Если время окончания установлено, форматируем его, иначе возвращаем null
        return $this->end_time ? $this->end_time->format('d.m.Y H:i') : null;
    }

    /**
     * Проверка доступности сеанса для бронирования.
     * Сеанс доступен, если он еще не завершился.
     *
     * @return bool
     */
    public function isAvailable()
    {
        // Сеанс доступен для бронирования, если время окончания больше текущего времени
        return $this->end_time > now();
    }
}
