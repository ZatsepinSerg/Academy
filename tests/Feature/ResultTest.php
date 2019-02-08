<?php

namespace Tests\Unit;

use App\Result;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResultTest extends TestCase
{

    protected $hash;
    protected $resultObj;


    const  PARAMS = [
        "result" => 4,
        "email" => 'test@mail.com',
        "img" => '/url/img/link.png',
        "time:finish" => 1000,
        "time:start" => 100,

    ];

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        $this->hash = Str::random();
        $this->resultObj = new Result();

        parent::__construct($name, $data, $dataName);
    }

    public function testClearStudentResult()
    {
        foreach (self::PARAMS AS $key => $param) {
            Redis::set("student:{$this->hash}:{$key}", $param);
            $this->resultObj->clearStudentResult($this->hash);
            $this->assertEmpty(Redis::get("student:{$this->hash}:{$key}"));
        }
    }

    public function testGetResultTest()
    {
        foreach (self::PARAMS AS $key => $param) {
            Redis::set("student:{$this->hash}:{$key}", $param);
        }
        $resulArray = $this->resultObj->getResultTest($this->hash);

        $this->assertEquals([
            "image" => "/url/img/link.png",
            "email" => "test@mail.com",
            "result" => "4",
            "totalTime" => 900],$resulArray);

    }

}
