<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function searchCity(Request $request)
    {
        $data = $request->only(['city_name', 'state_id']);
        $validator = Validator::make(
            $data,
            [
                'city_name' => 'string|min:1',
                'federative_unit_id' => 'string|min:2|max:2|exists:states,id',
            ],
            $this->customMessages
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors(), 100001);
        }

        return (new ResourceService())->searchCity($data['city']);
    }

    public function listFederativeUnits(): array
    {
        return (new ResourceService())->listFederativeUnits();
    }
}
