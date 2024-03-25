<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyMember extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'dob', 'type', 'signature', 'customer_id', 'terms_and_conditions', 'wavier_status'];

  
    /**
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function signature(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => base64_decode($value),
            set: fn ($value) => base64_encode($value),
        );
    }
    
    public function scopeExcludeForSnapshot($query, $value = []) 
    {
        $fillablesForSnapShot = $this->fillable;
        array_unshift($fillablesForSnapShot, 'id');
        return $query->select(array_diff($fillablesForSnapShot, (array) $value));
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
