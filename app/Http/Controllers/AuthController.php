<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Validator;
use Exception;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $authService)
    {
        $this->service = $authService;
    }

    /**
     * @OA\Post(
     * path="/api/auth/login",
     * summary="Auth Login",
     * description="Login an existing user",
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
     *              @OA\Property(property="auth_info", type="object",
     *                  @OA\Property(property="id", type="integer", example=21),
     *                  @OA\Property(property="name", type="string", example="Eletrocardiograma"),
     *                  @OA\Property(property="main", type="boolean", example=0),
     *                  @OA\Property(property="worker_id", type="integer", example=null),
     *                  @OA\Property(property="member_id", type="integer", example=2),
     *                  @OA\Property(property="company_id", type="integer", example=null),
     *              )
     *          )
     *       )
     *    )
     * )
     * )
     */
    public function login(Request $request)
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

        return $this->service->login($credentials);
    }

    /**
     * @OA\Post(
     * path="/api/auth/create",
     * summary="Auth Create",
     * description="Create a new user",
     * operationId="auth_create",
     * tags={"Auth"},
     * security={{}},
     * @OA\RequestBody(
     *    required=true,
     *    description="The request body receives email and password and a password confirmation",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="email", type="string", example="email@email.com", maxLength=100),
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
     *              @OA\Property(property="auth_info", type="object",
     *                  @OA\Property(property="id", type="integer", example=21),
     *                  @OA\Property(property="name", type="string", example="Eletrocardiograma"),
     *                  @OA\Property(property="main", type="boolean", example=0),
     *                  @OA\Property(property="worker_id", type="integer", example=null),
     *                  @OA\Property(property="member_id", type="integer", example=2),
     *                  @OA\Property(property="company_id", type="integer", example=null),
     *              )
     *          )
     *       )
     *    )
     * )
     * )
     */
    protected function create(Request $request)
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

        return $this->service->create($credentials);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
