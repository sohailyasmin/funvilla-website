<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WavierSnapshot extends Model
{
    use HasFactory;

    protected $fillable = [ 'title', 'snapshot', 'customer_id', 'status' ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->title = generateUniqueCode();
        });
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function snapshot(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    } 

    /**
     * Local scope to exclude non acive snapshot
     * @param $query
     * @return mixed
     */
    public function scopeActiveWavierSnapshot($query): mixed
    {
        return $query->where('status', '=', 1);
    }

    // adding wavier signature snapshot
    public function wavierSignatureSnapshots()
    {
        return $this->hasMany(WavierSignatureSnapshot::class);
    }

    /**
     * Get the post that owns the comment.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}