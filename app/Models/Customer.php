<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'news_subscription' => 'boolean',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'address',
        'city',
        'state',
        'phone',
        'postal_code',
        'dob',
        'location_id',
        'account_type_id',
        'organisation_name',
        'heard_about_us',
        'country_code',
        'news_subscription',
        'waiver_via',
        'user_id',
    ];

    // one locations have many customers
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // adding family members
    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }

    // adding wavier snapshot
    public function wavierSnapshots()
    {
        return $this->hasMany(WavierSnapshot::class)->orderBy('created_at', 'DESC');
    }

    // adding wavier remarks
    public function remarks()
    {
        return $this->hasMany(CustomerRemark::class);
    }

    // adding wavier signature snapshot
    public function wavierSignatureSnapshots()
    {
        return $this->hasMany(WavierSignatureSnapshot::class);
    }

    public function scopeExcludeForSnapshot($query, $value = [])
    {
        return $query->select(array_diff($this->fillable, (array) $value));
    }

    public static function emailExists($email)
    {
        return DB::table('users')->where('email', $email)->exists();
    }
}
