<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CoinPriceHistory;
use App\Services\CoinGeeckoService;
use App\Repositories\SQLCoinPriceHistoryRepository;
use App\Validations\CoinValidation;

class CryptoController extends Controller
{
    protected $coingeeckoService;
    protected $coinPriceHistoryRepository;
    protected $coinValidation;

    public function __construct(
        CoinGeeckoService $coingeeckoService,
        SQLCoinPriceHistoryRepository $coinPriceHistoryRepository,
        CoinValidation $coinValidation
    ) {
        $this->coinValidation = $coinValidation;
        $this->coingeeckoService = $coingeeckoService;
        $this->coinPriceHistoryRepository = $coinPriceHistoryRepository;
        $this->coinPossibilities = ['luna-1x', 'ethereum', 'bitcoin', 'dacxi', 'atomic-token', 'atn', 'atomic-wallet-coin'];
    }

    /**
     * Get the most recent price of a bitcoin
     *
     * @return \Illuminate\Http\Response
     */
    public function mostRecent(string $coin)
    {
        //!todo 
        // - jogar validaçoes para alguma outra camada ok
        $dt = new \DateTime();
        $params = "date=" . $dt->format("d-m-Y") . "&time=" . $dt->format("H:i");
        $coin = strtolower($coin);

        if (!in_array($coin, $this->coinPossibilities)) return $this->coinValidation->_errorResponse("Could not find coin with the given id", 404);

        $response = $this->coingeeckoService->getPrice($coin, $params);
        if ($response->getStatusCode() != 200) return $response;

        $response = json_decode($response->getBody()->getContents());
        if (!$this->coinValidation->_isValidResponse($response)) return $this->coinValidation->_errorResponse("Something wrong happens", 400);

        return $this->coinPriceHistoryRepository->create([
            'coingeecko_id' => $response->id,
            'symbol' => $response->symbol,
            'name' => $response->name,
            'thumb_url' => $response->image->thumb,
            'current_price' => $response->market_data->current_price->brl
        ]);
    }

    /**
     * Get the price of a crypto coin in a datetime
     *
     * @return \Illuminate\Http\Response
     */
    public function historyPrice($coin, Request $request)
    {
        $date = $request->date;
        $time = $request->time;

        if (!$time || !$date) return  $this->coinValidation->_errorResponse("Bad request!", 400);
        if (!in_array($coin, $this->coinPossibilities)) return  $this->coinValidation->_errorResponse("Could not find coin with the given id", 404);

        $params = "date=" . $date . "&time=" . $time;
        $coin = strtolower($coin);

        $response = $this->coingeeckoService->getPrice($coin, $params);
        if ($response->getStatusCode() != 200) return $response;

        $response = json_decode($response->getBody()->getContents());
        if (!$this->coinValidation->_isValidResponse($response)) return $this->coinValidation->_errorResponse("Something wrong happens", 400);

        return $this->coinPriceHistoryRepository->create([
            'coingeecko_id' => $response->id,
            'symbol' => $response->symbol,
            'name' => $response->name,
            'thumb_url' => $response->image->thumb,
            'current_price' => $response->market_data->current_price->brl
        ]);
    }
}
