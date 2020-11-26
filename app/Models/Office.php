<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Office extends Model
{
    use HasFactory, SoftDeletes;
    use Searchable;

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

    public function searchableAs()
    {
        return 'offices_index';
    }

    public function toSearchableArray()
    {
        /* $array = $this->toArray();

        // Customize array...

        return $array; */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'phone' => $this->phone,
            'email' => $this->email,

        ];
    }
}
