<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private AuthService $authService;
    private UserService $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     * path="/api/auth/create",
     * summary="Auth Create",
     * description="Create a new account",
     * operationId="auth_create",
     * tags={"Auth"},
     * security={{}},
     * @OA\RequestBody(
     *    required=true,
     *    description="The request body receives email and password and a password confirmation",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="email", type="string", example="hexabrasil@gmail.com", maxLength=100),
     *          @OA\Property(property="password", type="string", example="YouAmazingPasswordWithMinimunLenght8SpecialCharacterCapitalLetter", maxLength=100, description="The password must have at least 8 characters, one capital letter, one number and one special character"),
     *          @OA\Property(property="password_confirmation", type="string", example="YouAmazingPasswordWithMinimunLenght8SpecialCharacterCapitalLetter", maxLength=100, description="The password confirmation must be the same as the password")
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
    protected function create(Request $request): array
    {
        $credentials = $request->only(['email', 'password', 'password_confirmation']);

        $validator = Validator::make(
            $credentials,
            [
                'email' => 'required|email:rfc,dns',
                'password' => 'required|string|regex:^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$^', //Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character
                'password_confirmation' => 'required|same:password'
            ],
            $this->customMessages
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100002);
        }

        return $this->authService->create($credentials);
    }

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
     *              @OA\Property(property="email_verified", type="bool", example=true),
     *              @OA\Property(property="phone_verified", type="bool", example=false),
     *          ),
     *          @OA\Property(property="error", type="null", example=null)
     *       )
     *    )
     * )
     * )
     */
    public function login(Request $request): array
    {
        $credentials = $request->only(['email', 'password']);

        $validator = Validator::make(
            $credentials,
            [
                'email' => 'required|email:rfc,dns',
                'password' => 'required|string|min:6'
            ],
            $this->customMessages
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100001);
        }

        return $this->authService->login($credentials);
    }

    /**
     * @OA\Get(
     * path="/api/auth/logout",
     * summary="Auth Logout",
     * description="Logout an logged account",
     * operationId="auth_logout",
     * tags={"Auth"},
     * security={{"cuidamos_auth":{}}},
     * @OA\Response(
     *    response=200,
     *    description="Auth Data",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="message", type="string", example="Successfully logged out"),
     *          ),
     *          @OA\Property(property="error", type="null", example=null)
     *       )
     *    )
     * )
     * )
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout(auth()->user()->id);
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     * path="/api/phone/code/validate",
     * summary="Auth Phone Code Validate",
     * description="Validates the user phone number",
     * operationId="auth_validate_phone_code",
     * tags={"Auth"},
     * security={{"cuidamos_auth":{}}},
     * @OA\RequestBody(
     *    required=true,
     *    description="The request body receives the phone auth code",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="phone_code", type="string", example="123456")
     *       )
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Auth Data",
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
    public function validatePhoneCode(Request $request): void
    {
        $data = $request->only(['phone_code']);

        $validator = Validator::make(
            $data,
            [
                'phone_code' => 'required|string|min:6|max:6'
            ],
            $this->customMessages
        );
        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100001);
        }

        $this->authService->validatePhoneCode($data['phone_code'], auth()->user()->user->id);
    }

    /**
     * @OA\Post(
     * path="/api/phone/code/send",
     * summary="Auth Phone Code Send",
     * description="Send a sms to the phone number informed",
     * operationId="auth_send_phone_code",
     * tags={"Auth"},
     * security={{"cuidamos_auth":{}}},
     * @OA\RequestBody(
     *    required=true,
     *    description="The request body receives the phone number",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="phone_number", type="string", example="11999999999")
     *       )
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Auth Data",
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
    public function sendPhoneCode(Request $request): void
    {
        $data = $request->only(['phone_number']);

        $validator = Validator::make(
            $data,
            [
                'phone_number' => 'required|string|min:11|max:11|regex:/^([0-9\s\-\+\(\)]*)$/|unique:users,phone_number'
            ],
            $this->customMessages
        );
        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100001);
        }

        $this->userService->updateUser($data, auth()->user()->user->id);
    }

    /**
     * @OA\Get(
     * path="/api/auth/credentials/validate",
     * summary="Auth Credentials Validate",
     * description="Returns if both the user email and phone number is already validated",
     * operationId="auth_credentials_phone",
     * tags={"Auth"},
     * security={{"cuidamos_auth":{}}},
     * @OA\Response(
     *    response=200,
     *    description="Auth Data",
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
    public function validateCredentials(Request $request): array
    {
        $credentials = $request->only(['phone_code']);

        $validator = Validator::make(
            $credentials,
            [
                'email' => 'required|email:rfc,dns',
                'password' => 'required|string|min:6'
            ],
            $this->customMessages
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100001);
        }

        return $this->service->login($credentials);
    }
}
