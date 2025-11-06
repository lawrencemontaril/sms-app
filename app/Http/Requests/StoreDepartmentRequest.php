<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Department;
use Illuminate\Validation\Validator;

class StoreDepartmentRequest extends FormRequest
{
    /*
    | -----------------------------------------------------------
    |  Determine if the user is authorized to make this request.
    | -----------------------------------------------------------
    */
    public function authorize(): bool
    {
        return Gate::allows('create', Department::class);
    }

    /*
    | ---------------------------------------------
    |  Validation rules that apply to the request.
    | ---------------------------------------------
    */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2'
            ],
            'code' => [
                'required',
                'string',
                'min:2',
                'unique:departments,code'
            ]
        ];
    }
}
