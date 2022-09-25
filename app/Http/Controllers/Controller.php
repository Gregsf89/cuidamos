<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $customMessages = [
        'required' => 'required_field',
        'required_without_all' => 'at_least_one_field_required',
        'array' => 'invalid_value',
        'regex' => 'invalid_value',
        'int' => 'invalid_integer',
        'integer' => 'invalid_integer',
        'numeric' => 'invalid_number',
        'min' => 'invalid_min_value',
        'date' => 'invalid_date',
        'date_format' => 'invalid_date_format',
        'in' => 'invalid_value',
        'exists' => 'invalid_value',
        'max' => 'invalid_max_value',
        'after_or_equal' => 'invalid_after_value',
        'between' => 'invalid_between_value',
        'file' => 'invalid_file',
        'mimetypes' => 'invalid_format',
        'unique' => 'value_not_unique'
    ];
}
