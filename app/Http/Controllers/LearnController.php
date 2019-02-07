<?php

namespace App\Http\Controllers;

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

    public function __construct()
    {
        $this->task = new Task();
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
        $hash = Cookie::get('student');

        $user = new User();
        $user->setUserInfo($request, $hash);

        return redirect('/step-one');
    }

    public function stepOne()
    {
        $hash = Cookie::get('student');
        $this->task->generateTaskReadText($hash);

        return view('learn.step_one');
    }

    public function stepTwo()
    {
        $hash = Cookie::get('student');

        $this->task->checkTaskReadText($hash);
        $tasks = $this->task->generateSumNumber($hash);

        return view('learn.step_two', $tasks);
    }

    public function stepThree(Request $request)
    {
        $hash = Cookie::get('student');

        $request->validate(
            [
                'sum' => 'required|numeric',
            ]
        );

        $this->task->checkTaskSumNumber($request, $hash);
        $tasks = $this->task->generateTaskProgrammingLanguages();

        return view('learn.step_three', compact('tasks'));
    }

    public function stepFour(Request $request)
    {
        $hash = Cookie::get('student');

        $this->task->checkTaskProgrammingLanguages($request, $hash);

        $tasks = $this->task->generateTaskDayIsToday($hash);

        return view('learn.step_four', compact('tasks'));
    }

    public function finish(Request $request)
    {
        $hash = Cookie::get('student');

        $this->task->checkTaskDayIsToday($request, $hash);

        $result = new Result();

        $resultTest = $result->getResultTest($hash);

        if (empty($resultTest))
            throw new Exception('Result can`t empty');

        $result->saveResultTest($resultTest);

        return view('learn.finish', compact('resultTest'));
    }
}
