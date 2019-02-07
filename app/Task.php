<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class Task extends Model
{
    protected $hash;

    const LANGS_PROGRAMMING = [
        0 => 'Visual Basic',
        1 => 'PHP',
        2 => 'Python',
        3 => 'JS',
        4 => '.net',
    ];

    const DAYS = [
        1 => 'Понедельник',
        'Вторник', 'Среда', 'Четверг',
        'Пятница', 'Суббота', 'Воскресенье'];

    public function generateTaskStepOne(string $hash)
    {
        Redis::set("student:{$hash}:time:start", time());
    }

    public function generateTaskStepTwo(string $hash)
    {
        $numberOne = rand(0, 5);
        $numberTwo = rand(0, 5);

        $sum = $numberOne + $numberTwo;

        Redis::set("student:{$hash}:task:sum", $sum);

        return compact(['numberOne', 'numberTwo']);
    }

    public function generateTaskStepThree()
    {
        return self::LANGS_PROGRAMMING;
    }

    public function generateTaskStepFour(string $hash)
    {
        $today = date('N');

        Redis::set("student:{$hash}:task:today", $today);

        $days = self::DAYS;

        $tasks[$today] = $days[$today];

        unset($days[$today]);

        while (count($tasks) < 4) {
            $key = array_rand($days, 1);
            $day = $days[$key];
            $tasks[$key] = $day;
        }

        return $tasks;
    }

    public function checkTaskStepOne(string $hash)
    {
        Redis::incr("student:{$hash}:result");
    }

    public function checkTaskStepTwo(Request $request, string $hash)
    {
        if ($request->sum == Redis::get("student:{$hash}:task:sum")) {
            Redis::incr("student:{$hash}:result");
            Redis::delete("student:{$hash}:task:sum");
        }
    }

    public function checkTaskStepThree(Request $request, string $hash)
    {
        if (!empty($request->lang) && !in_array(0, $request->lang)) {
            Redis::incr("student:{$hash}:result");
        }
    }

    public function checkTaskStepFour(Request $request, string $hash)
    {
        if ($request->day == Redis::get("student:{$hash}:task:today")) {
            Redis::incr("student:{$hash}:result");
            Redis::delete("student:{$hash}:task:today");
        }

        Redis::set("student:{$hash}:time:finish", time());
    }

}
