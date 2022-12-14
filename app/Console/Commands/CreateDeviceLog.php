<?php

namespace App\Console\Commands;

use App\Wrappers\ServiceConnectionWrapper;
use Illuminate\Console\Command;

class CreateDeviceLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:log_device';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rn = mt_rand(1, 99);

        while (($rn % 10) == 0) {
            $rn = mt_rand(1, 99);
        }

        $data = [
            'device_id' => 1,
            'latitude' => -23.6049 - ($rn / 1000000),
            'longitude' => -46.6491 - ($rn / 1000000),
            'altitude' => 760 + (mt_rand(-10, 10)),
            'date' => today()->format('Y-m-d'),
            'time' => now()->format('H:i:s'),
            'speed' => (float) number_format(mt_rand(1, 10) / mt_rand(1, 10), 3),
            'accuracy' => $rn
        ];

        $url = env('EXT_URL') . '/api/device/log';

        (new ServiceConnectionWrapper())->post($url, ['ngrok-skip-browser-warning' => ''], $data);
    }
}
