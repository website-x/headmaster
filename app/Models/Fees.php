<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Fees extends Model
{
    use HasFactory, SoftDeletes;
    use Searchable;

    protected $appends = ['last_updated_at', 'last_created_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function collectedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function getLastUpdatedAtAttribute()
    {
        return $this->updated_at != null ? $this->updated_at->format('d-M-Y') : null;
    }

    public function getLastCreatedAtAttribute()
    {
        return $this->created_at != null ? $this->created_at->format('d-M-Y') : null;
    }

    public function searchableAs()
    {
        return 'fees_index';
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return [
            'id' => $this->id,
            'description' => $this->description,
            'amount' => $this->amount,
            'method' => $this->method,

        ];
    }
}
