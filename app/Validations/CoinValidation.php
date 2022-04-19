<?php

namespace App\Validations;

class CoinValidation
{
    public static function _errorResponse($message, $statusCode)
    {
        return response($message, $statusCode);
    }

    public static function _isValidResponse($response)
    {
        if ($response->id && $response->symbol  && $response->name && $response->image->thumb && $response->market_data->current_price->brl) return true;
        else return false;
    }
}
