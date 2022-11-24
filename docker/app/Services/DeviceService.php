<?php

namespace App\Services;

use App\Models\Device;
use App\Repositories\DeviceRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class DeviceService
 * @package App\Services
 */
class DeviceService extends Service
{
    /**
     * Display a listing of the resource.
     *
     * @param int $userId
     * @return Collection|null
     */
    public function list(int $userId): ?Collection
    {
        return (new  DeviceRepository())->list($userId);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $wardshipId
     * @param string $deviceId
     * @return Device
     */
    public function link(int $wardshipId, string $deviceId): Device
    {
        return (new DeviceRepository())->link($wardshipId, $deviceId);
    }

    /**
     * Display the specified resource.
     *
     * @param string $imei
     * @return Device|null
     */
    public function getByImei(string $imei)
    {
        return (new DeviceRepository())->getByImei($imei);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $wardshipId
     * @param string $deviceId
     * @return void
     */
    public function unlink(int $wardshipId, string $deviceId): void
    {
        (new DeviceRepository())->unlink($wardshipId, $deviceId);
    }
}
