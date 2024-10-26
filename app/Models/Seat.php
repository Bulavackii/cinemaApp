<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'cinema_hall_id',
        'row',
        'seat_number',
        'type',
    ];

    /**
     * Связь с кинозалом.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cinemaHall()
    {
        return $this->belongsTo(CinemaHall::class);
    }

    /**
     * Связь с билетами.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }

    /**
     * Проверка, является ли место VIP.
     * 
     * @return bool
     */
    public function isVip()
    {
        return $this->type === 'vip';
    }

    /**
     * Проверка, занято ли место.
     * 
     * @return bool
     */
    public function isBooked()
    {
        return $this->ticket()->exists();
    }
}
