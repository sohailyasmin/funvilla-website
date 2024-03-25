<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WavierSignatureSnapshot extends Model
{
    use HasFactory;

    protected $fillable = [ 'signature_snapshot', 'status', 'customer_id', 'family_member_id', 'wavier_snapshot_id'];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function signatureSnapshot(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => base64_decode($value),
            set: fn ($value) => base64_encode($value),
        );
    } 

    /**
     * Local scope to exclude non acive snapshot
     * @param $query
     * @return mixed
     */
    public function scopeActiveWavierSignatureSnapshot($query): mixed
    {
        return $query->where('status', '=', 1);
    }

    /**
     * Get the post that owns the comment.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}