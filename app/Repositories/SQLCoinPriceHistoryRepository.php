<?php

namespace App\Repositories;

use App\Interfaces\CoinPriceHistoryRepo;
use App\Models\Models\CoinPriceHistory;

class SQLCoinPriceHistoryRepository implements CoinPriceHistoryRepo
{
    public function create($data)
    {
        return CoinPriceHistory::create($data);
    }
}