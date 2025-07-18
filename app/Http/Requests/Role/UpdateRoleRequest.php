<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:roles,name,'  . $this->route('role'),
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'permissions' => 'array|exists:permissions,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The role name must be unique.',
            'name.string' => 'The role name must be a string.',
            'display_name.string' => 'The display name must be a string.',
            'description.string' => 'The description must be a string.',
            'permissions.array' => 'Permissions must be an array.',
            'permissions.exists' => 'One or more selected permissions do not exist.',
        ];
    }
}
