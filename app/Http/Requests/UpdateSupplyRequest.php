<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateSupplyRequest extends FormRequest
{
    /*
    | -----------------------------------------------------------
    |  Determine if the user is authorized to make this request.
    | -----------------------------------------------------------
    */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->supply);
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
            'description' => [
                'nullable',
                'string',
                'min:2'
            ],
            'price' => [
                'required',
                'min:0'
            ],
            'quantity' => [
                'required',
                'integer',
                'min:0'
            ],
            'reorder_level' => [
                'required',
                'integer',
                'min:0'
            ],
        ];
    }
}
