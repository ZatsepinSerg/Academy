<?php

use Illuminate\Database\Seeder;

class ResultSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Result::class,30)->create();
    }
}
