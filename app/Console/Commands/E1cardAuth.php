<?php

namespace App\Console\Commands;

use App\E1cardService;
use Illuminate\Console\Command;

class E1cardAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'e1card:auth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to get token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new E1cardService)->callAuth();
    }
}
