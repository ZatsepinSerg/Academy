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

    /**
     * Index page show ten last result and form create new test
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $hash = Str::random();
        Cookie::queue('student', $hash, 60);

        $result = new Result();
        $lastResult = $result->getLastResult();

        return view('learn.index', compact('lastResult'));
    }

    /**
     * Validate and save user info for new test
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * Set start time and generate task for read text
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stepReadText()
    {
        TimeHelper::setStartTime($this->hash);

        $text= $this->task->generateTaskReadText();

        return view('learn.step_one',compact('text'));
    }

    /**
     * Check of the task Read Text
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function checkStepReadText()
    {
        $this->task->checkTaskReadText($this->hash);

        return redirect('/step-two');
    }

    /**
     * Generate task for sum number
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stepSumNumber()
    {
        $tasks = $this->task->generateTaskSumNumber($this->hash);

        return view('learn.step_two', $tasks);
    }

    /**
     * Check of the task sum number
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * Generate task for programming languages
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stepProgrammingLanguages()
    {
        $tasks = $this->task->generateTaskProgrammingLanguages();

        return view('learn.step_three', compact('tasks'));
    }

    /**
     * Check of the task programming languages
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function checkProgrammingLanguages(Request $request)
    {
        $this->task->checkTaskProgrammingLanguages($request, $this->hash);

        return redirect('/step-four');
    }

    /**
     *  Generate task for day is today
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stepDayIsToday()
    {
        $tasks = $this->task->generateTaskDayIsToday($this->hash);

        return view('learn.step_four', compact('tasks'));
    }

    /**
     * Check of the task day is today
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function checkDayIsToday(Request $request)
    {
        $this->task->checkTaskDayIsToday($request, $this->hash);

        return redirect('/finish');
    }

    /**
     * Creating a report for passing the test
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     */
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
