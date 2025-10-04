<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimeHelper
{
    public static function jakartaNow()
    {
        return Carbon::now('Asia/Jakarta');
    }
    
    public static function toJakartaTime($timestamp)
    {
        return Carbon::parse($timestamp)->setTimezone('Asia/Jakarta');
    }
    
    public static function formatJakarta($format = 'Y-m-d H:i:s')
    {
        return self::jakartaNow()->format($format);
    }
    
    public static function jakartaISO()
    {
        return self::jakartaNow()->toISOString();
    }
}