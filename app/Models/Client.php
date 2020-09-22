<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

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
}
