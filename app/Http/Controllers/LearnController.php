<?php

namespace App\Http\Controllers;


use App\File;
use App\Result;
use App\Task;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    protected $task;

    public function __construct()
    {
        $this->task = new Task();
    }

    public function index()
    {
        $test = new Result();
        $lastResult = $test->getLastResult();

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

        $imgPath = File::saveImageStudent($request);
        //TODO:: сохранить в redis время начала и изображение/email
        return view('learn.step_one');
    }

    public function stepOne()
    {
        $tasks = $this->task->generateTaskStepTwo();

        return view('learn.step_two', $tasks);
    }

    public function stepTwo(Request $request)
    {
        $this->task->checkTaskStepOne($request);
        $tasks = $this->task->generateTaskStepThree();

        return view('learn.step_three', compact('tasks'));
    }

    public function stepThree(Request $request)
    {
        $this->task->checkTaskStepThree($request);

        $tasks = $this->task->generateTaskStepFour();

        return view('learn.step_four', compact('tasks'));
    }

    public function stepFour(Request $request)
    {
       $this->task->checkTaskStepFour($request);

       return redirect('/finish');
    }


    public function finish()
    {

    }
}
