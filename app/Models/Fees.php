<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fees extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['last_updated_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function collectedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getLastUpdatedAtAttribute()
    {
        return $this->updated_at != null ? $this->updated_at->format('d-M-Y') : null;
    }
}
