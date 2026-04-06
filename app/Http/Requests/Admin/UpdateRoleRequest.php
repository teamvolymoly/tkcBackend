<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use App\Services\AdminPermissionRegistry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
        $role = $this->route('role');
        $roleId = $role instanceof Role ? $role->getKey() : $role;

        return [
            'name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('roles', 'name')
                    ->ignore($roleId)
                    ->where(fn ($query) => $query->where('guard_name', $guardName)),
            ],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [
                'string',
                Rule::in(AdminPermissionRegistry::permissionNames()),
            ],
        ];
    }
}
