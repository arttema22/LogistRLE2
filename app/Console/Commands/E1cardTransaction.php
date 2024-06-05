<?php

namespace App\Console\Commands;

use App\E1cardService;
use Illuminate\Console\Command;

class E1cardTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'e1card:transaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to start get data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new E1cardService)->callTransaction();
    }
}
