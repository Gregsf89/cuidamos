<?php

namespace App\Http\Controllers;

use App\Services\DeviceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class DeviceController extends Controller
{
    private DeviceService $service;

    public function __construct(DeviceService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post(
     * path="/api/device/log",
     * summary="Device Log",
     * description="Register a GNSS log of a device",
     * operationId="device_log",
     * tags={"Device"},
     * security={{}},
     * @OA\RequestBody(
     *    required=true,
     *    description="The request body receives the GNSS data",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="device_id", type="integer", example="1"),
     *          @OA\Property(property="latitude", type="number", format="double", example=-23.123456),
     *          @OA\Property(property="longitude", type="number", format="double", example=-45.123456),
     *          @OA\Property(property="altitude", type="number", format="double", example=621.1),
     *          @OA\Property(property="date", type="string", example="2022-01-01"),
     *          @OA\Property(property="time", type="string", example="10:01:59"),
     *          @OA\Property(property="speed", type="number", format="double", example=10.45),
     *          @OA\Property(property="accuracy", type="integer", example="São Paulo")
     *       )
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Device Log Data",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="data", type="null", example=null),
     *          @OA\Property(property="error", type="null", example=null)
     *       )
     *    )
     * )
     * )
     */
    public function registerLog(Request $request): void
    {
        $data = $request->only([
            'device_id',
            'latitude',
            'longitude',
            'altitude',
            'date',
            'time',
            'speed',
            'accuracy'
        ]);

        $validator = Validator::make(
            $data,
            [
                'device_id' => 'required|integer|exists:devices,id,deleted_at,NULL',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'altitude' => 'required|numeric',
                'date' => 'required|date_format:Y-m-d',
                'time' => 'required|date_format:H:i:s',
                'speed' => 'nullable|numeric',
                'accuracy' => 'nullable|numeric'
            ],
            $this->customMessages
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100001);
        }

        $this->service->registerLog($data);
    }

    public function link(Request $request) //: array
    {
        $data = $request->only(['device_id', 'wardship_id']);
        $user = auth()->user();

        $validator = Validator::make(
            $data,
            [
                'device_id' => 'required|string|min:1|exists:devices,id,deleted_at,NULL,wardship_id,NULL',
                'wardship_id' => "required|integer|min:1|exists:wardships,id,deleted_at,NULL,user_id,{$user->id}"
            ],
            $this->customMessages
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100001);
        }

        // return (new DeviceService())->link($data['wardship_id'], $data['device_id']);
    }

    public function getByImei(Request $request) //: array
    {
        $data = $request->only(['device_imei']);

        $validator = Validator::make(
            $data,
            [
                'device_imei' => 'required|string|exists:devices,imei,deleted_at,NULL,wardship_id,NULL',
            ],
            $this->customMessages
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100001);
        }

        // return (new DeviceService())->link($data['wardship_id'], $data['device_id']);
    }

    public function unlink(Request $request): void
    {
        $data = $request->only(['device_id', 'wardship_id']);
        $user = auth()->user();

        $validator = Validator::make(
            $data,
            [
                'device_id' => [
                    'required',
                    'integer',
                    'min:1',
                    "exists:devices,id,deleted_at,NULL,wardship_id,{$data['wardship_id']}",
                ],
                'wardship_id' => "required|integer|min:1|exists:wardships,id,deleted_at,NULL,user_id,{$user->id}"
            ],
            $this->customMessages
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100001);
        }

        // (new DeviceService())->unlink($data['wardship_id'], $data['device_id']);
    }
}
