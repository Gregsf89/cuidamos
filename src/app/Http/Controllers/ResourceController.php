<?php

namespace App\Http\Controllers;

use App\Services\ResourceService;
use Illuminate\Http\Request;
use Validator;
use Exception;

class ResourceController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/city/search",
     * summary="City Search",
     * description="Search for a city by name",
     * operationId="resource_city_search",
     * tags={"Resource"},
     * security={{"cuidamos_auth":{}}},
     * @OA\RequestBody(
     *    required=true,
     *    description="The request body receives an array of objects containing the city_name and/or federative_unit_id as initials",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="city_name", type="string", example="São Paulo"),
     *          @OA\Property(property="federative_unit_id", type="string", example="SP", description="the initials of the federative unit")
     *       )
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="City Data",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="cities_info", type="array", example={{"id": 2245, "name": "Abadia dos Dourados", "federative_unit_id": "MG"}},
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example="1"),
     *                      @OA\Property(property="name", type="string", example="Abadia dos Dourados"),
     *                      @OA\Property(property="federative_unit_id", type="string", example="MG")
     *                  )
     *              )
     *          ),
     *          @OA\Property(property="error", type="null", example=null)
     *       )
     *    )
     * )
     * )
     */
    public function searchCity(Request $request): array
    {
        $data = $request->only(['city_name', 'federative_unit_id']);
        $validator = Validator::make(
            $data,
            [
                'city_name' => 'string|min:4',
                'federative_unit_id' => 'string|min:2|max:2|exists:federative_units,id',
            ],
            $this->customMessages
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100001);
        }

        return ['cities_info' => (new ResourceService())->searchCity($data)->toArray()];
    }

    /**
     * @OA\Get(
     * path="/api/federative_units/list",
     * summary="Federative Units List",
     * description="List all federative units",
     * operationId="resource_federative_unit_list",
     * tags={"Resource"},
     * security={{"cuidamos_auth":{}}},
     * @OA\Response(
     *    response=200,
     *    description="Federative Unit Data",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="federative_units_info", type="array", example={{"id": "AC", "name": "Acre"}, {"id": "AL", "name": "Alagoas"}, {"..."}},
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="string", example="AC"),
     *                      @OA\Property(property="name", type="string", example="Acre")
     *                  )
     *              )
     *          ),
     *          @OA\Property(property="error", type="null", example=null)
     *       )
     *    )
     * )
     * )
     */
    public function listFederativeUnits(): array
    {
        return ['federative_units_info' => (new ResourceService())->listFederativeUnits()->toArray()];
    }

    /**
     * @OA\Get(
     * path="/api/gender/list",
     * summary="Genders List",
     * description="List all genders",
     * operationId="resource_gender_list",
     * tags={"Resource"},
     * security={{"cuidamos_auth":{}}},
     * @OA\Response(
     *    response=200,
     *    description="Gender Data",
     *    @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="genders_info", type="array", example={{"id": 1, "name": "Male", "initials": "M"}, {"id": 2, "name": "Female", "initials": "F"}, { "id": 3, "name": "Other", "initials": "O"}},
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example="1"),
     *                      @OA\Property(property="name", type="string", example="Male"),
     *                      @OA\Property(property="initials", type="string", example="M")
     *                  )
     *              )
     *          ),
     *          @OA\Property(property="error", type="null", example=null)
     *       )
     *    )
     * )
     * )
     */
    public function listGender(): array
    {
        return ['genders_info' => (new ResourceService())->listGender()->toArray()];
    }
}
