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

    public function stepOne()
    {
        TimeHelper::setStartTime($this->hash);

        $this->task->generateTaskReadText($this->hash);

        return view('learn.step_one');
    }

    public function stepTwo()
    {
        $this->task->checkTaskReadText($this->hash);
        $tasks = $this->task->generateTaskSumNumber($this->hash);

        return view('learn.step_two', $tasks);
    }

    public function stepThree(Request $request)
    {
        $request->validate(
            [
                'sum' => 'required|numeric',
            ]
        );

        $this->task->checkTaskSumNumber($request, $this->hash);
        $tasks = $this->task->generateTaskProgrammingLanguages();

        return view('learn.step_three', compact('tasks'));
    }

    public function stepFour(Request $request)
    {
        $this->task->checkTaskProgrammingLanguages($request, $this->hash);

        $tasks = $this->task->generateTaskDayIsToday($this->hash);

        return view('learn.step_four', compact('tasks'));
    }

    public function finish(Request $request)
    {
        TimeHelper::setEndTime($this->hash);

        $this->task->checkTaskDayIsToday($request, $this->hash);

        $result = new Result();

        $resultTest = $result->getResultTest($this->hash);

        if (empty($resultTest))
            throw new Exception('Result can`t empty');

        $result->saveResultTest($resultTest);

        return view('learn.finish', compact('resultTest'));
    }
}
