<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;


class Result extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'grades', 'total_time'];

    public function getLastResult()
    {
        return Result::select('email', 'grades', 'total_time')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    }

    public function saveResultTest(array $params)
    {
        $result = new Result();
        $result->email = $params['email'];
        $result->grades = $params['result'];
        $result->total_time = $params['totalTime'];
        $result->save();

    }

    public function getResultTest(string $hash)
    {
        $result = [];

        $startTest = Redis::get("student:{$hash}:time:start");
        $finishTest = Redis::get("student:{$hash}:time:finish");

        $result['image'] = Redis::get("student:{$hash}:img");
        $result['email'] = Redis::get("student:{$hash}:email");
        $result['result'] = Redis::get("student:{$hash}:result", 0);
        $result['totalTime'] = $finishTest - $startTest;

        Redis::delete("student:{$hash}:result",
            "student:{$hash}:email",
            "student:{$hash}:img",
            "student:{$hash}:time:finish",
            "student:{$hash}:time:start"
        );

        return $result;
    }
}
