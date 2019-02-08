<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class Task extends Model
{
    /**
     * Need for test knowledge of programming languages
     */
    const LANGS_PROGRAMMING = [
        0 => 'Visual Basic',
        1 => 'PHP',
        2 => 'Python',
        3 => 'JS',
        4 => '.net',
    ];

    /**
     * Need for test what day is today
     */
    const DAYS = [
        1 => 'Понедельник',
        2 => 'Вторник',
        3 => 'Среда',
        4 => 'Четверг',
        5 => 'Пятница',
        6 => 'Суббота',
        7 => 'Воскресенье'
    ];

    /**
     * @param string $hash
     */
    public function generateTaskReadText(string $hash): void
    {

    }

    /**
     * @param string $hash
     * @return array
     */
    public function generateTaskSumNumber(string $hash): array
    {
        $numberOne = rand(0, 5);
        $numberTwo = rand(0, 5);

        $sum = $numberOne + $numberTwo;

        Redis::set("student:{$hash}:task:sum", $sum);

        return compact(['numberOne', 'numberTwo']);
    }

    /**
     * @return array
     */
    public function generateTaskProgrammingLanguages(): array
    {
        return self::LANGS_PROGRAMMING;
    }

    /**
     * @param string $hash
     * @return array
     */
    public function generateTaskDayIsToday(string $hash): array
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

    /**
     * @param string $hash
     */
    public function checkTaskReadText(string $hash): void
    {
        if (!Redis::get("student:{$hash}:task:text:check", 0))
            Redis::incr("student:{$hash}:result");

        Redis::set("student:{$hash}:task:text:check", 1);
    }

    /**
     * @param Request $request
     * @param string $hash
     */
    public function checkTaskSumNumber(Request $request, string $hash): void
    {
        if (!Redis::get("student:{$hash}:task:sum:check", 0)) {
            if ($request->sum == Redis::get("student:{$hash}:task:sum"))
                Redis::incr("student:{$hash}:result");

            Redis::set("student:{$hash}:task:sum:check", 1);
        }
    }

    /**
     * @param Request $request
     * @param string $hash
     */
    public function checkTaskProgrammingLanguages(Request $request, string $hash): void
    {
        if (!Redis::get("student:{$hash}:task:lang:check", 0)) {
            if (!empty($request->lang) && !in_array(0, $request->lang))
                Redis::incr("student:{$hash}:result");

            Redis::set("student:{$hash}:task:lang:check", 1);
        }
    }

    /**
     * @param Request $request
     * @param string $hash
     */
    public function checkTaskDayIsToday(Request $request, string $hash): void
    {
        if (!Redis::get("student:{$hash}:task:today:check", 0)) {
            if ($request->day == Redis::get("student:{$hash}:task:today"))
                Redis::incr("student:{$hash}:result");

            Redis::set("student:{$hash}:task:today:check", 1);
        }
    }
}
