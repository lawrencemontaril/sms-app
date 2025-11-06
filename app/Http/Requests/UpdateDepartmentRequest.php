<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Department;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
{
    /*
    | -----------------------------------------------------------
    |  Determine if the user is authorized to make this request.
    | -----------------------------------------------------------
    */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->department);
    }

    /*
    | ---------------------------------------------
    |  Validation rules that apply to the request.
    | ---------------------------------------------
    */
    public function rules(): array
    {
        return [
            'user_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id')
            ],
            'name' => [
                'required',
                'string',
                'min:2'
            ],
            'code' => [
                'required',
                'string',
                'min:2',
                Rule::unique('departments', 'code')->ignore($this->department)
            ]
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            switch ($this->department->code) {
                case 'PROCR':
                    $requiredRole = 'admin';
                    break;
                case 'FIN':
                    $requiredRole = 'accountant';
                    break;
                default:
                    $requiredRole = 'faculty';
                    break;
            }

            if (!$this->input('user_id')) {
                return;
            }

            $user = User::findOrFail($this->user_id);

            if (!$user->hasRole($requiredRole)) {
                $validator->errors()->add('user_id', "User is not a $requiredRole member.");
            }

            if ($user && $user->department->isNot($this->department)) {
                dd($user->department_id, $this->user_id, $this->department->id, $user, $this);
                $validator->errors()->add('user_id', 'User does not belong to this department.');
            }
        });
    }
}
