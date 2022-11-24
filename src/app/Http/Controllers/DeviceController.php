<?php

namespace App\Http\Controllers;

use App\Services\DeviceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class DeviceController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/auth/login",
     * summary="Auth Login",
     * description="Login an existing account",
     * operationId="auth_login",
     * tags={"Auth"},
     * security={{}},
     * @OA\RequestBody(
     *    required=true,
     *    description="The request body receives email and password",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="email", type="string", example="email@email.com", maxLength=100),
     *          @OA\Property(property="password", type="string", example="YouAmazingPasswordWithMinimunLenght8SpecialCharacterCapitalLetter", maxLength=100)
     *       )
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Auth Data",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJnRFdxSnM3M0tQWlhLYjhqUU9tZTFadkNIemsyIiwiaXNzIjoiaHR0cDovL2N1aWRhbS5vcyIsImlhdCI6MTY2ODg2NjUwNiwiZXhwIjoxNjY4OTUyOTA2LCJuYmYiOjE2Njg4NjY1MDZ9.wY8VmD--_wln_UN6bW3AiSYiv5F9s-P2H0NiwCklSBk"),
     *              @OA\Property(property="email_link_confirmation", type="string", example="https://cuidamos-91643.firebaseapp.com/__/auth/action?mode=verifyEmail&oobCode=4Rg_o4AQMQEDIIAkJHWZLqctXNa8QGcdq39TmSMtFtUAAAGEkDH9nQ&apiKey=AIzaSyAMbxYok6O6NrdTkGb-O47TObrx1DUTjFw&lang=en")
     *          ),
     *          @OA\Property(property="error", type="null", example=null)
     *       )
     *    )
     * )
     * )
     */
    public function list() //: array
    {
        $user = auth()->user();
        return (new DeviceService())->list($user->id);
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

        return (new DeviceService())->link($data['wardship_id'], $data['device_id']);
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
