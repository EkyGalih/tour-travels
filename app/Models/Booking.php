<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'booking_date' => 'date',
        'status' => BookingStatus::class,
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
