<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    // Указываем поля, которые могут быть заполнены массово
    protected $fillable = [
        'cinema_hall_id',  // ID кинозала, к которому относятся цены
        'price_regular',   // Цена для обычных мест
        'price_vip',       // Цена для VIP мест
    ];

    /**
     * Связь с кинозалом.
     * Цена принадлежит конкретному кинозалу.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cinemaHall()
    {
        // Определяем, что цена принадлежит конкретному кинозалу (отношение "многие к одному")
        return $this->belongsTo(CinemaHall::class);
    }
}
