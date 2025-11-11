<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'event_id',
        'email',
        'phone',
        'subject',
        'message',
        'address',
        'type',
        'event_ticket_no',
        'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
