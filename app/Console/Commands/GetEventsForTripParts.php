<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\TripPart;
use App\TrenordTripPart;
use App\TripPartManagers\TrenordTripPartManager;

class GetEventsForTripParts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getEvents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get events for all the trip parts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tripParts = TripPart::where([
            ['is_checked', '=', 0],
            ['details_type', '=', TrenordTripPart::class]
        ])->get();

        foreach ($tripParts as $tripPart) {
            TrenordTripPartManager::getEvents($tripPart);
        }

        $this->info('Events updated');
    }
}
