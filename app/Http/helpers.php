<?php

function currency($code='NGN') {
    $code = strtoupper($code);

    $currencies = [
        'NGN'=>'₦',//'&#x20A6;'
        'USD'=>'$'//'&#x24;'
    ];

    if (array_key_exists($code, $currencies)) {
        return $currencies[$code];
    }

    return $currencies['NGN'];
}

function balance() {
    return \Illuminate\Support\Facades\Cache::remember('balance', 60, function () {
        $response = (new App\Paystack\PaystackApi)->getBalance();
        return currency($response['data'][0]['currency']).number_format($response['data'][0]['balance']/100,2);
    });
}

function raw_balance() {
    return \Illuminate\Support\Facades\Cache::remember('raw_balance', 60, function () {
        $response = (new App\Paystack\PaystackApi)->getBalance();
        return $response['data'][0]['balance']/100;
    });
}

function formatted_balance() {
    $balance = balance();

    if ($balance > 999999999) {
        return currency().number_format($balance/1000000000).'B';
    } elseif ($balance > 999999) {
        return currency().number_format($balance/1000000).'M';
    } elseif ($balance > 999) {
        return currency().number_format($balance/1000).'K';
    } else {
        return currency().number_format($balance);
    }
}

function auto_topup()
{
    return \Illuminate\Support\Facades\Cache::rememberForever('auto_topup', function () {
        return false;
    });
}