<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['full_name','father_full_name','full_address','total_payments'];

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function payments()
    {
        return $this->hasMany(Fees::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFatherFullNameAttribute()
    {
        return "{$this->father_first_name} {$this->father_last_name}";
    }

    public function getTotalPaymentsAttribute()
    {
        return '₹' . number_format($this->payments->sum('amount'),  2, '.' , ',' );
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address} {$this->city} {$this->state} {$this->country}";
    }
}
