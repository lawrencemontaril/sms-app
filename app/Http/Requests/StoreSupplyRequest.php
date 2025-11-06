<?php

namespace App\Http\Requests;

use App\Models\Supply;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreSupplyRequest extends FormRequest
{
    /*
    | -----------------------------------------------------------
    |  Determine if the user is authorized to make this request.
    | -----------------------------------------------------------
    */
    public function authorize(): bool
    {
        return Gate::allows('create', Supply::class);
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
