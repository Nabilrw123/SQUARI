<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Factory;
use Carbon\Carbon;

class TriggerFeederFromSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feeder:trigger-from-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trigger feeder based on schedule in Firebase';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $factory = (new Factory)->withServiceAccount(base_path('storage/app/firebase/firebase_credentials.json'));
        $database = $factory->createDatabase();

        $now = Carbon::now()->format('H:i');
        $schedules = $database->getReference('dashboard/schedules')->getValue();

        if (!$schedules) {
            $this->info('No schedules found.');
            return;
        }

        foreach ($schedules as $id => $schedule) {
            if (
                ($schedule['status'] ?? '') === 'active' &&
                ($schedule['action'] ?? '') === 'beri_pakan' &&
                ($schedule['time'] ?? '') === $now
            ) {
                // Trigger pakan
                $database->getReference('dashboard/control/pakan')->set(true);
                $this->info("Triggered feeder for schedule: $id at $now");
                // Reset to false after 3 seconds
                sleep(3);
                $database->getReference('dashboard/control/pakan')->set(false);
            }
        }
    }
}
