<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    // Указываем поля, которые могут быть массово заполнены
    protected $fillable = [
        'seance_id',   // ID сеанса, к которому относится билет
        'user_id',     // ID пользователя, который забронировал билет
        'seat_row',    // Ряд, в котором находится место
        'seat_number', // Номер места
        'seat_type',   // Тип места (обычное или VIP)
        'price',       // Цена билета
        'qr_code',     // QR-код для билета
    ];

    /**
     * Связь с сеансом.
     * Билет принадлежит конкретному сеансу.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seance()
    {
        // Билет принадлежит одному сеансу (отношение "многие к одному")
        return $this->belongsTo(Seance::class);
    }

    /**
     * Связь с пользователем.
     * Билет принадлежит пользователю, который его забронировал.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        // Билет принадлежит одному пользователю (отношение "многие к одному")
        return $this->belongsTo(User::class);
    }
}
