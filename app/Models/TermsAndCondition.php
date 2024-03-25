<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TermsAndCondition extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [ 'text','is_default','location_id', 'title', 'description' ];

    // one locations have many customers
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Local scope to exclude auth user
     * @param $query
     * @return mixed
     */
    public function scopeDefaultTermsAndCondition($query): mixed
    {
        return $query->where('is_default', '=', 1);
    }

    /**
     * Local scope to exclude auth user
     * @param $query
     * @return mixed
     */
    public function scopeNotDefaultTermsAndCondition($query): mixed
    {
        return $query->where('is_default', '=', 0);
    }
}
