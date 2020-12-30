<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $appends = ['last_updated_at', 'last_created_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function spentBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getLastUpdatedAtAttribute()
    {
        return $this->updated_at != null ? $this->updated_at->format('d-M-Y') : null;
    }

    public function getLastCreatedAtAttribute()
    {
        return $this->created_at != null ? $this->created_at->format('d-M-Y') : null;
    }
}
