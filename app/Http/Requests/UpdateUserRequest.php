<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Validation\Rules;

class UpdateUserRequest extends FormRequest
{
    /*
    | -----------------------------------------------------------
    |  Determine if the user is authorized to make this request.
    | -----------------------------------------------------------
    */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->user);
    }

    /*
    | --------------------------------------------------------------
    |  Filter out empty password fields so validation ignores them.
    | --------------------------------------------------------------
    */
    protected function prepareForValidation(): void
    {
        if ($this->filled('password') && $this->input('password') === '') {
            $this->request->remove('password');
            $this->request->remove('password_confirmation');
        }
    }

    /*
    | ---------------------------------------------
    |  Validation rules that apply to the request.
    | ---------------------------------------------
    */
    public function rules(): array
    {
        return [
            'department_id' => [
                'required',
                'integer',
                Rule::exists('departments', 'id')
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user),
            ],
            'password' => [
                'nullable',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ];
    }
}
