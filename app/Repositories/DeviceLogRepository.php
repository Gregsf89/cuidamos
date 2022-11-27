<?php

namespace App\Repositories;

use App\Models\DeviceLog;

/**
 * Class DeviceLogRepository
 * @package App\Repositories
 */
class DeviceLogRepository extends Repository
{
    /**
     * @param array $data
     * @return void
     */
    public function registerLog(array $data): void
    {
        DeviceLog::create($data)->fresh();
    }
}
