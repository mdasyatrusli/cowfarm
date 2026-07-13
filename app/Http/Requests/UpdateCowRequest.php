<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateCowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by CowPolicy via authorizeResource
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $cow = $this->route('cow');
        $farmId = $cow?->farm_id ?? Auth::user()->farm_id;

        return [
            'tag_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('cows', 'tag_number')
                    ->ignore($cow)
                    ->where(fn ($query) => $query->where('farm_id', $farmId)),
            ],
            'name' => ['nullable', 'string', 'max:255'],
            'breed_id' => ['required', 'exists:breeds,id'],
            'gender' => ['required', 'string', Rule::in(['male', 'female'])],
            'birth_date' => ['nullable', 'date'],
            'status' => ['required', 'string', Rule::in(['active', 'sold', 'dead'])],
        ];
    }

    /**
     * Prepare the data for validation.
     * Remove farm_id from the request data so it's never user-supplied.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('farm_id') && ! Auth::user()->isSuperAdmin()) {
            $this->request->remove('farm_id');
        }
    }
}
