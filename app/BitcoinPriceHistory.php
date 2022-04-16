<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BitcoinPriceHistory extends Model
{
    protected $fillable = [
        'coingeecko_id',
        'symbol',
        'name',
        'thumb_url',
        'current_price'
    ];

}