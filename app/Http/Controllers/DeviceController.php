<?php

namespace App\Http\Controllers;

use App\Services\DeviceService;
use Illuminate\Http\Request;
use Validator;
use Exception;

class DeviceController extends Controller
{
    public function list(): array
    {
        $user = auth()->user();
        return (new DeviceService())->list($user->id);
    }

    public function link(Request $request): array
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

        return (new DeviceService())->link($data['wardship_id'], $data['device_id']);
    }

    public function getByImei(Request $request): array
    {
        $data = $request->only(['device_id', 'wardship_id']);

        $validator = Validator::make(
            $data,
            [
                'imei' => 'required|string|exists:devices,imei,deleted_at,NULL,wardship_id,NULL',
            ],
            $this->customMessages
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100001);
        }

        return (new DeviceService())->link($data['wardship_id'], $data['device_id']);
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

        (new DeviceService())->unlink($data['wardship_id'], $data['device_id']);
    }
}
