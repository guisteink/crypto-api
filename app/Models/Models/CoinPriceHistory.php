<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;

class CoinPriceHistory extends Model
{
    protected $fillable = [
        'coingeecko_id',
        'symbol',
        'name',
        'thumb_url',
        'current_price'
    ];
}
