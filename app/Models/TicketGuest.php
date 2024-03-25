<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TicketGuest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'age_to', 
        'age_from', 
        'condition',
        'allowed_guests',
        'ticket_id'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}