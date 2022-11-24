<?php

namespace App\Repositories;

use App\Models\Device;
use Exception;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class DeviceRepository
 * @package App\Repositories
 */
class DeviceRepository extends Repository
{
    /**
     * Display a listing of the resource.
     *
     * @param int $userId
     * @return Collection|null
     */
    public function list(int $userId): ?Collection
    {
        return Device::select('id', 'wardship_id', 'imei', 'Imei', 'carrier_name', 'carrier_number')->whereIn('wardship_id', function ($query) use ($userId) {
            $query->select('id')->from('wardships')->where('user_id', $userId);
        })->get();
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
        try {
            $device = Device::where('id', $deviceId)->first();
        } catch (Exception) {
            throw new Exception('device_not_found', 100001);
        }

        if ($device->wardship_id) {
            throw new Exception('device_already_linked', 100002);
        }

        $device->fill('wardship_id', $wardshipId)->save();

        return $device->fresh();
    }

    /**
     * Display the specified resource.
     *
     * @param string $imei
     * @return Device|null
     */
    public function getByImei(string $imei)
    {
        return Device::select('id')->where('imei', $imei)->first();
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
        Device::where(['wardship_id' => $wardshipId, 'device_id' => $deviceId])->delete();
    }
}
