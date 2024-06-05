<?php

namespace App\Console\Commands;

use App\MonopolyService;
use Illuminate\Console\Command;

class MonopolyAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monopoly:auth';

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
        (new MonopolyService)->callAuth();
    }
}
