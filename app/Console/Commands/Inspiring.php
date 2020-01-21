<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Inspiring extends Command
{
    protected $signature = "inspire";

    public function handle()
    {
        $this->comment("\n".app(\Gmsantos\Inspiring::class)->quote()."\n");
    }
}