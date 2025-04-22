<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderNumberGenerator
{
    private const ORDER_NUMBER_PREFIX = 'ORD';

    public static function generate(): string
    {
        $date = Carbon::now()->format('Ymd');
        $prefix = "ORD-{$date}-";

        $newNum = ($last =Order::latest()->first()->id)? $last :1 ;

        return $prefix . $newNum; 
    }
}