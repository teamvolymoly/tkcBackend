<?php

namespace App\Http\Requests\Admin;

use App\Services\AdminPermissionRegistry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'permissions' => array_values(array_filter((array) $this->input('permissions', []))),
        ]);
    }

    public function rules(): array
    {
        $guardName = config('auth.defaults.guard', 'web');

        return [
            'name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('roles', 'name')->where(fn ($query) => $query->where('guard_name', $guardName)),
            ],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [
                'string',
                Rule::in(AdminPermissionRegistry::permissionNames()),
            ],
        ];
    }
}
