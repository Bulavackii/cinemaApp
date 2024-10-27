<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    // Указываем поля, которые могут быть массово заполнены
    protected $fillable = [
        'cinema_hall_id',  // ID кинозала, к которому относится место
        'row',             // Номер ряда
        'seat_number',     // Номер места в ряду
        'type',            // Тип места (обычное или VIP)
    ];

    /**
     * Связь с кинозалом.
     * Место принадлежит конкретному кинозалу.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cinemaHall()
    {
        // Место принадлежит одному кинозалу (отношение "многие к одному")
        return $this->belongsTo(CinemaHall::class);
    }

    /**
     * Связь с билетом.
     * Каждое место может быть связано с одним билетом.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ticket()
    {
        // Место может быть связано с одним билетом (отношение "один к одному")
        return $this->hasOne(Ticket::class);
    }

    /**
     * Проверка, является ли место VIP.
     * Возвращает true, если тип места VIP.
     * 
     * @return bool
     */
    public function isVip()
    {
        // Если тип места 'vip', возвращаем true
        return $this->type === 'vip';
    }

    /**
     * Проверка, занято ли место.
     * Возвращает true, если место уже забронировано.
     * 
     * @return bool
     */
    public function isBooked()
    {
        // Место считается занятым, если есть связанный билет
        return $this->ticket()->exists();
    }
}
