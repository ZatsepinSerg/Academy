<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 08.02.2019
 * Time: 12:27
 */

namespace App\Http\Controllers\Helpers;


use Illuminate\Support\Facades\Redis;

class TimeHelper
{

    public static function setStartTime($hash): void
    {
        Redis::set("student:{$hash}:time:start", time());
    }

    public static function setEndTime($hash): void
    {
        Redis::set("student:{$hash}:time:finish", time());
    }
}