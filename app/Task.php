<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Task extends Model
{

    public function generateTaskStepTwo()
    {
        $numberOne = rand(0, 5000);
        $numberTwo = rand(0, 5000);

        $sum = $numberOne + $numberTwo;

        //set in cache

        return compact(['numberOne','numberTwo']);
    }

    public function generateTaskStepThree()
    {
        $langProgramming = [
            0 => 'Visual Basic',
            1 => 'PHP',
            2 => 'Python',
            3 => 'JS',
            4 => '.net',
        ];

        return $langProgramming;
    }

    public function generateTaskStepFour()
    {
        $days = [
            1 => 'Понедельник',
            'Вторник', 'Среда', 'Четверг',
            'Пятница', 'Суббота', 'Воскресенье'];

        $today = date('N');
// save in cache
        $tasks[$today] = $days[$today];

        unset($days[$today]);

        while (count($tasks) < 4) {
            $key = array_rand($days, 1);
            $day = $days[$key];
            $tasks[$key] = $day;
        }

        return $tasks;
    }

    public function checkTaskStepOne(Request $request)
    {

    }

    public function checkTaskStepTwo(Request $request)
    {
        if (!empty($request->lang) && !in_array(0, $request->lang)) {
            //add in cache  + 1
        }

    }
    public function checkTaskStepThree(Request $request)
    {

    }

    public function checkTaskStepFour(Request $request)
    {

    }

}
