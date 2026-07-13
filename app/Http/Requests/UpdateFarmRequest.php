<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateFarmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by FarmPolicy/controller
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:500'],
        ];

        // Only super_admin can change owner_id when updating a farm
        if (Auth::user()?->isSuperAdmin()) {
            $rules['owner_id'] = ['sometimes', 'exists:users,id'];
        }

        return $rules;
    }
}
