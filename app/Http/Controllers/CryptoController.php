<?php

namespace App\Http\Controllers;

use App\BitcoinPriceHistory;
use App\Services\CoinGeecko;
use Illuminate\Http\Request;

class CryptoController extends Controller
{
    protected $coingeeckoService;

    public function __construct(CoinGeecko $coingeeckoService)
    {
        $this->coingeeckoService = $coingeeckoService;
        $this->coinPossibilities = ['luna-1x', 'ethereum', 'bitcoin', 'dacxi', 'atomic-token', 'atn', 'atomic-wallet-coin'];
    }

    /**
     * Get the most recent price of a bitcoin
     *
     * @return \Illuminate\Http\Response
     */
    public function mostRecent($coin)
    {
        $dt = new \DateTime();
        $params = "date=" . $dt->format("d-m-Y") . "&time=" . $dt->format("H:i");
        $coin = strtolower($coin);

        if (!in_array($coin, $this->coinPossibilities)) return response("Could not find coin with the given id", 404);

        $response = $this->coingeeckoService->getPrice($coin, $params);
        if ($response->getStatusCode() != 200) return $response;

        $response = json_decode($response->getBody()->getContents());

        $newPrice = new BitcoinPriceHistory();
        $newPrice->coingeecko_id = $response->id;
        $newPrice->symbol = $response->symbol;
        $newPrice->name = $response->name;
        $newPrice->thumb_url = $response->image->thumb;
        $newPrice->current_price = $response->market_data->current_price->brl;

        $newPrice->save();

        return $newPrice;
    }

    /**
     * Get the most recent price of a datetime
     *
     * @return \Illuminate\Http\Response
     */
    public function historyPrice($coin, Request $request)
    {
        $date = $request->date;
        $time = $request->time;
        
        if (!$time || !$date) return response("Bad request!", 404);
        if (!in_array($coin, $this->coinPossibilities)) return response("Could not find coin with the given id", 404);

        $params = "date=" . $date . "&time=" . $time;
        $coin = strtolower($coin);

        $response = $this->coingeeckoService->getPrice($coin, $params);
        if ($response->getStatusCode() != 200) return $response;

        $response = json_decode($response->getBody()->getContents());

        $newPrice = new BitcoinPriceHistory();
        $newPrice->coingeecko_id = $response->id;
        $newPrice->symbol = $response->symbol;
        $newPrice->name = $response->name;
        $newPrice->thumb_url = $response->image->thumb;
        $newPrice->current_price = $response->market_data->current_price->brl;

        $newPrice->save();

        return $newPrice;
    }
}
