<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
    use HasFactory, SoftDeletes;

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
    public function fees()
    {
        return $this->hasMany(Fees::class);
    }
    public function employees()
    {
        return $this->hasMany(User::class);
    }
    
}
