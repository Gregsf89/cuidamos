<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private UserService $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    /**
     * @OA\Post(
     * path="/api/user/create",
     * summary="User Create",
     * description="Creates a new user",
     * operationId="user_create",
     * tags={"User"},
     * security={{"cuidamos_auth":{}}},
     * @OA\RequestBody(
     *    required=true,
     *    description="The request body receives an array of objects containing the account and device info",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="user_info", type="object",
     *              @OA\Property(property="city_id", type="integer", example="23"),
     *              @OA\Property(property="gender_id", type="integer", example="1"),
     *              @OA\Property(property="document", type="string", example="32165498732"),
     *              @OA\Property(property="first_name", type="string", example="João"),
     *              @OA\Property(property="last_name", type="string", example="Silva"),
     *              @OA\Property(property="address", type="string", example="Rua ABC do D"),
     *              @OA\Property(property="zip_code", type="string", example="02330020"),
     *              @OA\Property(property="date_of_birth", type="string", format="date", example="2022-01-01"),
     *              @OA\Property(property="address_complement", type="string", example="AP 145 BL 2", description="can be null")
     *          )
     *       )
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="User Data",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="user_info", type="object",
     *                  @OA\Property(property="id", type="integer", example="1"),
     *                  @OA\Property(property="account_id", type="integer", example="1"),
     *                  @OA\Property(property="email", type="string", example="email@email.com"),
     *                  @OA\Property(property="uid", type="string", example="gDWqJs73KPZXKb8jQOme1ZvCHzk2"),
     *                  @OA\Property(property="phone", type="string", example="+5511987654321"),
     *                  @OA\Property(property="state", type="string", example="Bahia"),
     *                  @OA\Property(property="city", type="string", example="Salvador"),
     *                  @OA\Property(property="gender", type="string", example="Male"),
     *                  @OA\Property(property="document", type="string", example="32165498765"),
     *                  @OA\Property(property="uuid", type="string", example="36b43ea9-d061-48c1-9d61-df7c7ba0d9aa"),
     *                  @OA\Property(property="first_name", type="string", example="João"),
     *                  @OA\Property(property="last_name", type="string", example="Silva"),
     *                  @OA\Property(property="address", type="string", example="Rua Abc do D"),
     *                  @OA\Property(property="zip_code", type="string", example="02330012"),
     *                  @OA\Property(property="date_of_birth", type="string", format="date", example="2022-01-01"),
     *                  @OA\Property(property="address_complement", type="string", example="Bloco 2 AP 145", description="can be null")
     *              )
     *          ),
     *          @OA\Property(property="error", type="null", example=null)
     *       )
     *    )
     * )
     * )
     */
    public function create(Request $request): array
    {
        $data = $request->only([
            'city_id',
            'gender_id',
            'document',
            'first_name',
            'last_name',
            'address',
            'zip_code',
            'date_of_birth',
            'address_complement'
        ]);

        $validator = Validator::make(
            $data,
            [
                'city_id' => 'required|integer|exists:cities,id',
                'gender_id' => 'required|integer|exists:genders,id',
                'document' => 'required|string|min:11|max:14',
                'first_name' => 'required|string|min:3|max:255',
                'last_name' => 'required|string|min:3|max:255',
                'address' => 'required|string|min:3|max:255',
                'zip_code' => 'required|string|min:8|max:8',
                'date_of_birth' => 'required|date_format:Y-m-d',
                'address_complement' => 'nullable|string|min:1|max:255'
            ],
            $this->customMessages
        );
        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100007);
        }

        $data['account_id'] = auth()->user()->id;
        return (new UserResource(
            $this->service->create($data)
        ))->resolve();
    }

    /**
     * @OA\Get(
     * path="/api/user/show",
     * summary="User Show Info",
     * description="User get info",
     * operationId="user_show",
     * tags={"User"},
     * security={{"cuidamos_auth":{}}},
     * @OA\Response(
     *    response=200,
     *    description="User Data",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="user_info", type="object",
     *                  @OA\Property(property="id", type="integer", example="1"),
     *                  @OA\Property(property="account_id", type="integer", example="1"),
     *                  @OA\Property(property="email", type="string", example="email@email.com"),
     *                  @OA\Property(property="uid", type="string", example="gDWqJs73KPZXKb8jQOme1ZvCHzk2"),
     *                  @OA\Property(property="phone", type="string", example="+5511987654321"),
     *                  @OA\Property(property="state", type="string", example="Bahia"),
     *                  @OA\Property(property="city", type="string", example="Salvador"),
     *                  @OA\Property(property="gender", type="string", example="Male"),
     *                  @OA\Property(property="document", type="string", example="32165498765"),
     *                  @OA\Property(property="uuid", type="string", example="36b43ea9-d061-48c1-9d61-df7c7ba0d9aa"),
     *                  @OA\Property(property="first_name", type="string", example="João"),
     *                  @OA\Property(property="last_name", type="string", example="Silva"),
     *                  @OA\Property(property="address", type="string", example="Rua Abc do D"),
     *                  @OA\Property(property="zip_code", type="string", example="02330012"),
     *                  @OA\Property(property="date_of_birth", type="string", format="date", example="2022-01-01"),
     *                  @OA\Property(property="address_complement", type="string", example="Bloco 2 AP 145", description="can be null")
     *              )
     *          ),
     *          @OA\Property(property="error", type="null", example=null)
     *       )
     *    )
     * )
     * )
     */
    public function show(): array
    {
        return (new UserResource(
            $this->service->show(auth()->user()->id)
        ))->resolve();
    }

    /**
     * @OA\Post(
     * path="/api/user/update",
     * summary="User Update",
     * description="User update",
     * operationId="user_update",
     * tags={"User"},
     * security={{"cuidamos_auth":{}}},
     * @OA\RequestBody(
     *    description="User update arguments",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *           @OA\Property(property="user_info", type="object",
     *              @OA\Property(property="city_id", type="integer", example="23"),
     *              @OA\Property(property="gender_id", type="integer", example="1"),
     *              @OA\Property(property="document", type="string", example="32165498732"),
     *              @OA\Property(property="uuid", type="string", example="19cce9f8-627e-4f30-a077-f888124a1a06"),
     *              @OA\Property(property="first_name", type="string", example="João"),
     *              @OA\Property(property="last_name", type="string", example="Silva"),
     *              @OA\Property(property="address", type="string", example="Rua ABC do D"),
     *              @OA\Property(property="zip_code", type="string", example="02330020"),
     *              @OA\Property(property="date_of_birth", type="string", format="date", example="2022-01-01"),
     *              @OA\Property(property="address_complement", type="string", example="AP 145 BL 2", description="can be null")
     *          )
     *       )
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="User Data",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="user_info", type="object",
     *                  @OA\Property(property="id", type="integer", example="1"),
     *                  @OA\Property(property="account_id", type="integer", example="1"),
     *                  @OA\Property(property="email", type="string", example="email@email.com"),
     *                  @OA\Property(property="uid", type="string", example="gDWqJs73KPZXKb8jQOme1ZvCHzk2"),
     *                  @OA\Property(property="phone", type="string", example="+5511987654321"),
     *                  @OA\Property(property="state", type="string", example="Bahia"),
     *                  @OA\Property(property="city", type="string", example="Salvador"),
     *                  @OA\Property(property="gender", type="string", example="Male"),
     *                  @OA\Property(property="document", type="string", example="32165498765"),
     *                  @OA\Property(property="uuid", type="string", example="36b43ea9-d061-48c1-9d61-df7c7ba0d9aa"),
     *                  @OA\Property(property="first_name", type="string", example="João"),
     *                  @OA\Property(property="last_name", type="string", example="Silva"),
     *                  @OA\Property(property="address", type="string", example="Rua Abc do D"),
     *                  @OA\Property(property="zip_code", type="string", example="02330012"),
     *                  @OA\Property(property="date_of_birth", type="string", format="date", example="2022-01-01"),
     *                  @OA\Property(property="address_complement", type="string", example="Bloco 2 AP 145", description="can be null")
     *              )
     *          ),
     *          @OA\Property(property="error", type="null", example=null)
     *       )
     *    )
     * )
     * )
     */
    public function update(Request $request): array
    {
        $data = $request->only([
            'city_id',
            'gender_id',
            'document',
            'first_name',
            'last_name',
            'address',
            'zip_code',
            'date_of_birth',
            'address_complement'
        ]);

        $validator = Validator::make(
            $data,
            [
                'city_id' => 'required|integer|exists:cities,id',
                'gender_id' => 'required|integer|exists:genders,id',
                'document' => 'required|string|min:11|max:14',
                'first_name' => 'required|string|min:3|max:255',
                'last_name' => 'required|string|min:3|max:255',
                'address' => 'required|string|min:3|max:255',
                'zip_code' => 'required|string|min:8|max:8',
                'date_of_birth' => 'required|date_format:Y-m-d',
                'address_complement' => 'nullable|string|min:1|max:255'
            ],
            $this->customMessages
        );
        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100009);
        }

        return (new UserResource(
            $this->service->update($data)
        ))->resolve();
    }
}
