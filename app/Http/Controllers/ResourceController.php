<?php

namespace App\Http\Controllers;

use App\Services\ResourceService;
use Illuminate\Http\Request;
use Validator;
use Exception;

class ResourceController extends Controller
{
    public function searchCity(Request $request)
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

        return (new ResourceService())->searchCity($data);
    }

    public function listFederativeUnits(): array
    {
        return (new ResourceService())->listFederativeUnits()->toArray();
    }

    public function listGender(): array
    {
        return (new ResourceService())->listGender()->toArray();
    }
}
