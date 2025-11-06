<?php

namespace App\Http\Requests;

use App\Models\Supply;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSupplyRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subject' => ['required', 'string'],
            'message' => ['nullable', 'string'],
            'supply_request_items' => ['required', 'array', 'min:1'],
            'supply_request_items.*.supply_id' => [
                'required',
                'integer',
                Rule::exists('supplies', 'id'),
            ],
            'supply_request_items.*.quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    // Extract the index from the attribute like "supply_request_items.0.quantity"
                    preg_match('/supply_request_items\.(\d+)\.quantity/', $attribute, $matches);
                    $index = $matches[1] ?? null;

                    if ($index !== null) {
                        $supplyId = $this->input("supply_request_items.$index.supply_id");
                        $supply = Supply::find($supplyId);

                        if ($supply && $value > $supply->quantity) {
                            $fail("The quantity for {$supply->name} exceeds available stock ({$supply->stock}).");
                        }
                    }
                },
            ],
        ];
    }
}
