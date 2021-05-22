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

    public function getFeesAmountInWordsAttribute()
    {
        return $this->getIndianCurrency($this->amount);
    }

    private function getIndianCurrency(float $number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
                       3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                       7 => 'seven', 8 => 'eight', 9 => 'nine',
                       10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                       13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
                       16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
                       19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
                       40 => 'forty', 50 => 'fifty', 60 => 'sixty',
                       70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
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
