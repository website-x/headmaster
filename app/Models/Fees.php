<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fees extends Model
{
    use HasFactory, SoftDeletes;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function collectedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
