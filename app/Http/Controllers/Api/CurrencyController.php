<?php

namespace App\Http\Controllers\Api;

use App\Models\Currency;


class CurrencyController extends ApiController
{
    public function listData()
    {
        $currency_obj = Currency::with('networks')->where('is_active', 1)->get();
        $this->status = true;
        $this->message = "OK";
        $this->data = $currency_obj;
        return $this->jsonView();
    }
}
