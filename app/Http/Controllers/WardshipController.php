<?php

namespace App\Http\Controllers;

use App\Http\Resources\WardshipResource;
use App\Rules\CpfValidator;
use App\Services\WardshipService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WardshipController extends Controller
{
    private WardshipService $service;

    public function __construct(WardshipService $wardshipService)
    {
        $this->service = $wardshipService;
    }

    /**
     * @OA\Put(
     * path="/api/wardship/add",
     * summary="Wardship Add",
     * description="Creates or Updates a wardship",
     * operationId="wardship_add",
     * tags={"Wardship"},
     * security={{"cuidamos_auth":{}}},
     * @OA\RequestBody(
     *    required=true,
     *    description="The request body receives an array of objects containing the wardship info",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="wardship_info", type="object",
     *              @OA\Property(property="city_id", type="integer", example="1"),
     *              @OA\Property(property="gender_id", type="integer", example="1"),
     *              @OA\Property(property="first_name", type="string", example="João"),
     *              @OA\Property(property="last_name", type="integer", example="Silva"),
     *              @OA\Property(property="date_of_birth", type="string", format="date", example="2022-01-01"),
     *              @OA\Property(property="email", type="string", example="email@email.com"),
     *              @OA\Property(property="phone", type="string", example="+5511987654321"),
     *              @OA\Property(property="document", type="string", example="32165498721"),
     *              @OA\Property(property="uuid", type="string", example="373217ee-8cc4-4605-ab37-4da62d4f2b98"),
     *              @OA\Property(property="address", type="string", example="Rua ABC do D"),
     *              @OA\Property(property="zip_code", type="string", example="01452000")
     *          )
     *       )
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Wardship Data",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="wardship_info", type="object",
     *                  @OA\Property(property="id", type="integer", example="1"),
     *                  @OA\Property(property="user_id", type="integer", example="1"),
     *                  @OA\Property(property="city_id", type="integer", example="1"),
     *                  @OA\Property(property="gender_id", type="integer", example="1"),
     *                  @OA\Property(property="first_name", type="string", example="João"),
     *                  @OA\Property(property="last_name", type="integer", example="Silva"),
     *                  @OA\Property(property="date_of_birth", type="string", format="date", example="2022-01-01"),
     *                  @OA\Property(property="email", type="string", example="email@email.com"),
     *                  @OA\Property(property="phone", type="string", example="+5511987654321"),
     *                  @OA\Property(property="document", type="string", example="32165498721"),
     *                  @OA\Property(property="uuid", type="string", example="373217ee-8cc4-4605-ab37-4da62d4f2b98"),
     *                  @OA\Property(property="address", type="string", example="Rua ABC do D"),
     *                  @OA\Property(property="zip_code", type="string", example="01452000"),
     *                  @OA\Property(property="last_position_info", type="object",
     *                      @OA\Property(property="id", type="integer", example="1"),
     *                      @OA\Property(property="device_id", type="integer", example="1"),
     *                      @OA\Property(property="latitude", type="number", example=-23.5505199),
     *                      @OA\Property(property="longitude", type="number", example=-46.6333094),
     *                      @OA\Property(property="altitude", type="number", example=0.0),
     *                      @OA\Property(property="date", type="string", example="2022-01-01"),
     *                      @OA\Property(property="time", type="string", example="18:10:59"),
     *                      @OA\Property(property="speed", type="number", example="0.0"),
     *                      @OA\Property(property="accuracy", type="integer", example="1")
     *                  )
     *              )
     *          ),
     *          @OA\Property(property="error", type="null", example=null)
     *       )
     *    )
     * )
     * )
     */
    public function add(Request $request): array
    {
        $data = $request->only([
            'wardship_info.city_id',
            'wardship_info.gender_id',
            'wardship_info.first_name',
            'wardship_info.last_name',
            'wardship_info.date_of_birth',
            'wardship_info.email',
            'wardship_info.phone',
            'wardship_info.document',
            'wardship_info.uuid',
            'wardship_info.address',
            'wardship_info.zip_code'
        ]);

        $validator = Validator::make(
            $data,
            [
                'wardship_info' => 'required|array',
                'wardship_info.city_id' => 'required|integer|min:1|exists:cities,id',
                'wardship_info.gender_id' => 'required|integer|min:1|exists:genders,id',
                'wardship_info.first_name' => 'required|string|min:3|max:255',
                'wardship_info.last_name' => 'required|string|min:3|max:255',
                'wardship_info.date_of_birth' => 'required|date_format:Y-m-d',
                'wardship_info.email' => 'nulalble|unique:wardships,email|string|max:255|email:rfc,dns',
                'wardship_info.phone' => 'nullable|string|regex:/(5{2})[1-9]{2}[7-9][0-9]{8}$/|max:14|min:12',
                'wardship_info.document' => ['required', 'string', 'min:11', 'max:14', 'unique:wardships,document', new CpfValidator()],
                'wardship_info.address' => 'required|string|min:3|max:255',
                'wardship_info.zip_code' => 'required|string|min:8|max:8|regex:/[0-9]{8}/'
            ],
            $this->customMessages
        );
        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100007);
        }

        $data['wardship_info']['user_id'] = auth()->user()->user->id;

        return (new WardshipResource(
            $this->service->updateOrCreate($data['wardship_info'])
        ))->resolve();
    }

    /**
     * @OA\Get(
     * path="/api/wardship/show/{id}",
     * summary="Wardship Show",
     * description="Shows a specific wardship by it's id",
     * operationId="wardship_show",
     * tags={"Wardship"},
     * security={{"cuidamos_auth":{}}},
     * @OA\Response(
     *    response=200,
     *    description="Wardship Data",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="wardship_info", type="object",
     *                  @OA\Property(property="id", type="integer", example="1"),
     *                  @OA\Property(property="user_id", type="integer", example="1"),
     *                  @OA\Property(property="city_id", type="integer", example="1"),
     *                  @OA\Property(property="gender_id", type="integer", example="1"),
     *                  @OA\Property(property="first_name", type="string", example="João"),
     *                  @OA\Property(property="last_name", type="integer", example="Silva"),
     *                  @OA\Property(property="date_of_birth", type="string", format="date", example="2022-01-01"),
     *                  @OA\Property(property="email", type="string", example="email@email.com"),
     *                  @OA\Property(property="phone", type="string", example="+5511987654321"),
     *                  @OA\Property(property="document", type="string", example="32165498721"),
     *                  @OA\Property(property="uuid", type="string", example="373217ee-8cc4-4605-ab37-4da62d4f2b98"),
     *                  @OA\Property(property="address", type="string", example="Rua ABC do D"),
     *                  @OA\Property(property="zip_code", type="string", example="01452000"),
     *                  @OA\Property(property="last_position_info", type="object",
     *                      @OA\Property(property="id", type="integer", example="1"),
     *                      @OA\Property(property="device_id", type="integer", example="1"),
     *                      @OA\Property(property="latitude", type="number", example=-23.5505199),
     *                      @OA\Property(property="longitude", type="number", example=-46.6333094),
     *                      @OA\Property(property="altitude", type="number", example=0.0),
     *                      @OA\Property(property="date", type="string", example="2022-01-01"),
     *                      @OA\Property(property="time", type="string", example="18:10:59"),
     *                      @OA\Property(property="speed", type="number", example="0.0"),
     *                      @OA\Property(property="accuracy", type="integer", example="1")
     *                  )
     *              )
     *          ),
     *          @OA\Property(property="error", type="null", example=null)
     *       )
     *    )
     * )
     * )
     */
    public function show($id): array
    {
        return (new WardshipResource(
            $this->service->show($id)
        ))->resolve();
    }

    /**
     * @OA\Get(
     * path="/api/wardship/list",
     * summary="Wardship List",
     * description="list all wardships of a user",
     * operationId="wardship_list",
     * tags={"Wardship"},
     * security={{"cuidamos_auth":{}}},
     * @OA\Response(
     *    response=200,
     *    description="Wardship Data",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="wardships_info", type="array",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example="1"),
     *                      @OA\Property(property="user_id", type="integer", example="1"),
     *                      @OA\Property(property="city_id", type="integer", example="1"),
     *                      @OA\Property(property="gender_id", type="integer", example="1"),
     *                      @OA\Property(property="first_name", type="string", example="João"),
     *                      @OA\Property(property="last_name", type="integer", example="Silva"),
     *                      @OA\Property(property="date_of_birth", type="string", format="date", example="2022-01-01"),
     *                      @OA\Property(property="email", type="string", example="email@email.com"),
     *                      @OA\Property(property="phone", type="string", example="+5511987654321"),
     *                      @OA\Property(property="document", type="string", example="32165498721"),
     *                      @OA\Property(property="uuid", type="string", example="373217ee-8cc4-4605-ab37-4da62d4f2b98"),
     *                      @OA\Property(property="address", type="string", example="Rua ABC do D"),
     *                      @OA\Property(property="zip_code", type="string", example="01452000"),
     *                      @OA\Property(property="last_position_info", type="object",
     *                          @OA\Property(property="id", type="integer", example="1"),
     *                          @OA\Property(property="device_id", type="integer", example="1"),
     *                          @OA\Property(property="latitude", type="number", example=-23.5505199),
     *                          @OA\Property(property="longitude", type="number", example=-46.6333094),
     *                          @OA\Property(property="altitude", type="number", example=0.0),
     *                          @OA\Property(property="date", type="string", example="2022-01-01"),
     *                          @OA\Property(property="time", type="string", example="18:10:59"),
     *                          @OA\Property(property="speed", type="number", example="0.0"),
     *                          @OA\Property(property="accuracy", type="integer", example="1")
     *                      )
     *                  )
     *              )
     *          ),
     *          @OA\Property(property="error", type="null", example=null)
     *       )
     *    )
     * )
     * )
     */
    public function list(): array
    {
        return (new WardshipResource(
            $this->service->show(auth()->user()->id)
        ))->resolve();
    }

    /**
     * @OA\Delete(
     * path="/api/wardship/delete/{id}",
     * summary="Wardship Delete",
     * description="Deletes a wardship",
     * operationId="wardship_delete",
     * tags={"Wardship"},
     * security={{"cuidamos_auth":{}}},
     * @OA\Response(
     *    response=200,
     *    description="Wardship Data",
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
    public function delete($id): array
    {
        $userId = auth()->user()->user->id;

        $data['wardship_id'] = $id;

        $validator = Validator::make(
            $data,
            [
                'wardship_id' => "required|integer|exists:wardships,id,deleted_at,NULL,user_id,{$userId}"
            ],
            $this->customMessages
        );
        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100007);
        }

        return (new WardshipResource(
            $this->service->show(auth()->user()->id)
        ))->resolve();
    }
}
