<?php

namespace App\Services;

use App\Models\Device;
use App\Repositories\DeviceLogRepository;
use App\Repositories\DeviceRepository;

/**
 * Class DeviceService
 * @package App\Services
 */
class DeviceService extends Service
{
    private DeviceRepository $repository;

    public function __construct(DeviceRepository $repository)
    {
        $this->repository = $repository;
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
        return $this->repository->link($wardshipId, $deviceId);
    }

    /**
     * Display the specified resource.
     *
     * @param string $imei
     * @return Device|null
     */
    public function getByImei(string $imei)
    {
        return $this->repository->getByImei($imei);
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
        $this->repository->unlink($wardshipId, $deviceId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $wardshipId
     * @param string $deviceId
     * @return void
     */
    public function registerLog(array $data): void
    {
        (new DeviceLogRepository())->registerLog($data);
    }
}
