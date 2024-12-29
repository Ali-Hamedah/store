<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;


class CurrencyController extends Controller
{


    public function store(Request $request)
    {

        $request->validate([
            'currency_code' => 'required|string|size:3',
        ]);

        $baseCurrencyCode = config('app.currency');
        $currencyCode = $request->input('currency_code');

        $cacheKey = 'currency_rate_' . $currencyCode;

        $rate = Cache::get($cacheKey, 0);

        if (!$rate) {
            try {

                $converter = app('currency.converter');
                $rate = $converter->convert($baseCurrencyCode, $currencyCode);

                Cache::put($cacheKey, $rate, now()->addMinutes(360));
            } catch (\Exception $e) {

                return redirect()->back()->withErrors(['error' => 'Error fetching currency rate: ' . $e->getMessage()]);
            }
        }

        Session::put('currency_code', $currencyCode);

        return redirect()->back();
    }
}
