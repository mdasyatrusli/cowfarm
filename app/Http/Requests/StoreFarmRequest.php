<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreFarmRequest extends FormRequest
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

        // Only super_admin can set owner_id when creating a farm.
        // Use nullable (not sometimes) so the empty string submitted by the
        // "No owner assigned" option / hidden input passes validation instead
        // of failing with "The selected owner id is invalid."
        if (Auth::user()?->isSuperAdmin()) {
            $rules['owner_id'] = ['nullable', 'exists:users,id'];
        }

        return $rules;
    }
}
