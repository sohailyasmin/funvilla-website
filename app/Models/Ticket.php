<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 
        'display_name', 
        'status', 
        // 'type',
        // 'pass_type',
        'weekday_price',
        'weekend_price',
        'start_date_time',
        'end_date_time', 
        'location_id', 
        'description', 
        'display_description', 
        'category_ids', 
        'term_and_condition_id', 
        'play_time',
        'play_time_till_close',
        'advance_payment',
        'tax',
        'btn_img',
        'max_sale_per_order', 
        'min_sale_per_order', 
        'pos', 
        'one_bill_per_item', 
        'sell_and_register_customer', 
        'order_locked',
        'custom_price',
        'print_as_ticket',
        'print_tc_on_ticket',
        'tc_on_ticket_description'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function termAndCondition()
    {
        return $this->belongsTo(TermsAndCondition::class, 'term_and_condition_id');
    }

    protected function btnImg(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => base64_decode($value),
            set: fn ($value) => $value ? base64_encode($value) : null,
        );
    } 

    protected function playTime(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => array_combine(['hours', 'minutes', 'seconds'], array_map('intval', explode(":",$value))),
            set: fn (array $value) => implode(":",array_values($value)),
        );
    }

    protected function categoryIds(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Category::whereIn('id', explode(",",$value))->get()->toArray(),
            set: fn (array $value) => implode(",",array_column($value, 'id')),
        );
    }

}