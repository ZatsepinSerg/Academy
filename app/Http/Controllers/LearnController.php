<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\TimeHelper;
use App\Result;
use App\Task;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class LearnController extends Controller
{
    protected $task;
    protected $hash;

    public function __construct()
    {
        $this->task = new Task();

        $this->hash = Cookie::get('student');
    }

    public function index()
    {
        $hash = Str::random();
        Cookie::queue('student', $hash, 60);

        $result = new Result();
        $lastResult = $result->getLastResult();

        return view('learn.index', compact('lastResult'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|min:5|max:255',
                'file' => 'mimes:jpeg,bmp,png',
            ]
        );

        $user = new User();
        $user->setUserInfo($request, $this->hash);

        return redirect('/step-one');
    }

    public function stepReadText()
    {
        TimeHelper::setStartTime($this->hash);

        $this->task->generateTaskReadText($this->hash);

        return view('learn.step_one');
    }

    public function checkStepReadText()
    {
        $this->task->checkTaskReadText($this->hash);

        return redirect('/step-two');
    }

    public function stepSumNumber()
    {
        $tasks = $this->task->generateTaskSumNumber($this->hash);

        return view('learn.step_two', $tasks);
    }

    public function checkStepSumNumber(Request $request)
    {
        $request->validate(
            [
                'sum' => 'required|numeric',
            ]
        );

        $this->task->checkTaskSumNumber($request, $this->hash);

        return redirect('/step-three');
    }

    public function stepProgrammingLanguages()
    {
        $tasks = $this->task->generateTaskProgrammingLanguages();

        return view('learn.step_three', compact('tasks'));
    }

    public function checkProgrammingLanguages(Request $request)
    {
        $this->task->checkTaskProgrammingLanguages($request, $this->hash);

        return redirect('/step-four');
    }

    public function stepDayIsToday()
    {
        $tasks = $this->task->generateTaskDayIsToday($this->hash);

        return view('learn.step_four', compact('tasks'));
    }

    public function checkDayIsToday(Request $request)
    {
        $this->task->checkTaskDayIsToday($request, $this->hash);

        return redirect('/finish');
    }

    public function finish()
    {
        TimeHelper::setEndTime($this->hash);

        $result = new Result();
        $resultTest = $result->getResultTest($this->hash);

        if (empty($resultTest))
            throw new Exception('Result can`t empty');

        $result->saveResultTest($resultTest);

        return view('learn.finish', compact('resultTest'));
    }
}
