<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'cinema_hall_id',
        'price_regular',
        'price_vip',
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
}
