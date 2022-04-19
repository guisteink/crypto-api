<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CoinGeeckoService
{
    protected $base_url;

    public function __construct()
    {
        $this->base_url = "https://api.coingecko.com/api/v3/coins";
    }

    public function getPrice(string $coin, string $params)
    {
        $response = Http::get($this->base_url . '/' . $coin . '/history' . "?" . $params);

        return $response;
    }

} 
