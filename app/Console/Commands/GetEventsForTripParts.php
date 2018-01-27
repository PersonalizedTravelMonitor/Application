<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Trip;
use App\TripPart;
use App\TrenordTripPart;
use App\TripPartManagers\TrenordTripPartManager;
use Carbon\Carbon;

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

    protected $handlers = [
        TrenordTripPart::class => TrenordTripPartManager::class
    ];

    public function handle()
    {
        $trips = Trip::where('repeatingOn', '=', '[]')
            ->orWhere('repeatingOn', 'LIKE', '%' . Carbon::now()->format('N') . '%')
            ->get();

        foreach ($trips as $trip) {
            foreach ($trip->parts as $tripPart) {
                $manager = $this->handlers[$tripPart->details_type];
                $manager::getEvents($tripPart);
            }
        }

        $this->info('Events updated');
    }
}
