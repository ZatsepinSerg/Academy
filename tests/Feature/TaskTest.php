<?php

namespace Tests\Unit;

use App\Task;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{

    const LANGS_PROGRAMMING = [
        0 => 'Visual Basic',
        1 => 'PHP',
        2 => 'Python',
        3 => 'JS',
        4 => '.net',
    ];

    protected $task;
    protected $hash;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        $this->hash = Str::random();
        $this->task = new Task();
        parent::__construct($name, $data, $dataName);
    }

    public function testConstDays()
    {
        $this->assertIsArray(Task::DAYS);
    }

    public function testLangsProgramming()
    {
        $this->assertIsArray(Task::LANGS_PROGRAMMING);
    }

    public function testConstText()
    {
        $this->assertIsString(Task::TEXT);
    }


    public function testGenerateTaskSumNumberInCache()
    {
        $this->task->generateTaskSumNumber($this->hash);

        $this->assertNotEmpty(Redis::get("student:{$this->hash}:task:sum"));
    }

    public function testGenerateTaskSumNumberCheckSum()
    {
        $vars = $this->task->generateTaskSumNumber($this->hash);

        $sum = Redis::get("student:{$this->hash}:task:sum");

        $this->assertEquals(array_sum($vars), $sum);
    }

    public function testGenerateTaskSumNumberIntegerValueArray()
    {
        $vars = $this->task->generateTaskSumNumber($this->hash);
        $this->assertContainsOnly('integer', $vars);
    }

    public function testGenerateTaskProgrammingLanguagesIsArray()
    {
        $this->assertIsArray($this->task->generateTaskProgrammingLanguages());
    }

    public function testGenerateTaskProgrammingLanguagesContains()
    {
        $this->assertEquals(self::LANGS_PROGRAMMING, $this->task->generateTaskProgrammingLanguages());
    }


    public function testGenerateTaskDayIsTodayIsArray()
    {
        $this->assertIsArray($this->task->generateTaskDayIsToday($this->hash));
    }

    public function testGenerateTaskDayIsTodayInCache()
    {
        $today = date('N');
        $this->task->generateTaskDayIsToday($this->hash);

        $day = Redis::get("student:{$this->hash}:task:today");

        $this->assertContains($day, $today);
    }


    public function testGenerateTaskDayIsTodayInArray()
    {
        $today = date('N');
        $days = $this->task->generateTaskDayIsToday($this->hash);
        $days = array_flip($days);
        $this->assertContains($today, $days);
    }


    public function testCheckTaskReadTextTrue()
    {
        $this->task->checkTaskReadText($this->hash);

        $this->assertEquals(1, Redis::get("student:{$this->hash}:task:text:check"));

    }

    public function testCheckTaskReadTextIncrement()
    {
        $oldResult = Redis::get("student:{$this->hash}:result");

        $oldResult++;
        $this->task->checkTaskReadText($this->hash);

        $newResult = Redis::get("student:{$this->hash}:result");

        $this->assertEquals($oldResult, $newResult);
    }

    public function testCheckTaskReadTextFalse()
    {
        Redis::set("student:{$this->hash}:task:text:check", 1, 60);

        $oldResult = Redis::get("student:{$this->hash}:result");

        $this->task->checkTaskReadText($this->hash);

        $newResult = Redis::get("student:{$this->hash}:result");

        $this->assertEquals($oldResult, $newResult);
    }


    public function testCheckTaskSumNumberIncrement()
    {
        $sum = 10;
        $oldResult = Redis::get("student:{$this->hash}:result");
        Redis::set("student:{$this->hash}:task:sum", $sum, 60);
        $oldResult++;

        $request = new Request();
        $request->sum = $sum;

        $this->task->checkTaskSumNumber($request, $this->hash);

        $newResult = Redis::get("student:{$this->hash}:result");

        $this->assertEquals($oldResult, $newResult);
    }

    public function testCheckTaskSumNumberFalseIncrement()
    {
        $sum = 10;

        Redis::set("student:{$this->hash}:task:sum:check", 1, 60);

        $oldResult = Redis::get("student:{$this->hash}:result");
        Redis::set("student:{$this->hash}:task:sum", $sum, 60);

        $request = new Request();
        $request->sum = $sum;

        $this->task->checkTaskSumNumber($request, $this->hash);

        $newResult = Redis::get("student:{$this->hash}:result");

        $this->assertEquals($oldResult, $newResult);
    }

    public function testCheckTaskSumNumberSetMarkdown()
    {
        $sum = 10;

        Redis::set("student:{$this->hash}:task:sum", $sum, 60);

        $request = new Request();
        $request->sum = $sum;

        $this->task->checkTaskSumNumber($request, $this->hash);

        $this->assertEquals(1, Redis::get("student:{$this->hash}:task:sum:check"));

    }

    public function testCheckTaskProgrammingLanguagesIncrement()
    {
        $oldResult = Redis::get("student:{$this->hash}:result");
        $oldResult++;

        $request = new Request();
        $request->lang = [
            '1',
            '2'
        ];

        $this->task->checkTaskProgrammingLanguages($request, $this->hash);

        $newResult = Redis::get("student:{$this->hash}:result");

        $this->assertEquals($oldResult, $newResult);
    }

    public function testCheckTaskProgrammingLanguagesNotIncrement()
    {
        $oldResult = Redis::get("student:{$this->hash}:result", 0);

        $request = new Request();
        $request->lang = [
            '0',
            '1',
            '2'];
        $this->task->checkTaskProgrammingLanguages($request, $this->hash);

        $newResult = Redis::get("student:{$this->hash}:result", 0);

        $this->assertEquals($oldResult, $newResult);
    }

    public function testCheckTaskProgrammingLanguagesSetMarkdown()
    {
        $request = new Request();
        $request->lang = [
            '0',
            '1',
            '2'];

        $this->task->checkTaskProgrammingLanguages($request, $this->hash);

        $this->assertEquals(1, Redis::get("student:{$this->hash}:task:lang:check"));
    }


    public function testCheckTaskDayIsTodaySetMarkdown()
    {
        $request = new Request();
        $request->day = 5;

        $this->task->checkTaskDayIsToday($request, $this->hash);
        $this->assertEquals(1, Redis::get("student:{$this->hash}:task:today:check"));
    }

    public function testCheckTaskDayIsTodayIncrement()
    {
        $today = date('N');

        Redis::set("student:{$this->hash}:task:today",$today);

        $oldResult = Redis::get("student:{$this->hash}:result", 0);
        $oldResult++;

        $request = new Request();
        $request->day = $today;

        $this->task->checkTaskDayIsToday($request, $this->hash);

        $newResult = Redis::get("student:{$this->hash}:result");

        $this->assertEquals($oldResult, $newResult);

    }

    public function testCheckTaskDayIsTodayNotIncrement()
    {
        $today = date('N');

        Redis::set("student:{$this->hash}:task:today",$today);

        $oldResult = Redis::get("student:{$this->hash}:result", 0);


        $request = new Request();
        $request->day = 10;

        $this->task->checkTaskDayIsToday($request, $this->hash);

        $newResult = Redis::get("student:{$this->hash}:result");

        $this->assertEquals($oldResult, $newResult);

    }

}
