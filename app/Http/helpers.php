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