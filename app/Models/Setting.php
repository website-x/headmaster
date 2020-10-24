<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Setting extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $appends = ['readable_key'];

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    public function getReadableKeyAttribute()
    {
        return Str::title(str_replace('_', ' ', $this->key));
    }
}
