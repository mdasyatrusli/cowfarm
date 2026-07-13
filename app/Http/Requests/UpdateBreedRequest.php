<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBreedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by BreedPolicy via authorizeResource
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $breed = $this->route('breed');

        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('breeds', 'name')->ignore($breed)],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
