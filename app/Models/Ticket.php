<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'seance_id',
        'user_id',
        'seat_row',
        'seat_number',
        'seat_type',
        'price',
        'qr_code',
    ];

    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
