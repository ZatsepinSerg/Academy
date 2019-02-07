<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    public function getLastResult()
    {
       return Result::select('email','grades','total_time')
           ->orderBy('created_at','desc')
           ->take(10)
           ->get();
    }
}
