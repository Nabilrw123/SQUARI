<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSensorData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sensor-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $factory = (new \Kreait\Firebase\Factory())
            ->withServiceAccount(storage_path('app/firebase/firebase_credentials.json'))
            ->withDatabaseUri('https://smart-aquarium-3720d-default-rtdb.asia-southeast1.firebasedatabase.app');
        $db = $factory->createDatabase();

        for ($i = 0; $i < 100; $i++) {
            $data = [
                'suhu_ds18b20' => rand(250, 300) / 10,
                'suhu_bme280' => rand(260, 320) / 10,
                'kelembapan' => rand(50, 80),
                'tekanan' => rand(1000, 1020),
                'level_air' => rand(60, 90),
            ];
            $timestamp = now()->timestamp . $i;
            $db->getReference("dashboard/history/{$timestamp}")->set($data);
            $this->info("Data sent: " . json_encode($data));
            sleep(5); // interval 5 detik
        }
    }
}
