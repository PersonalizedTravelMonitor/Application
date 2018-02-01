<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Trip;

class CleanupDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanupDb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // remove trips that are not repeating
        Trip::where('repeatingOn', '=', '[]')->delete();
    }
}
