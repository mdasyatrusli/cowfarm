<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreFeedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by FeedPolicy via authorizeResource
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $farmId = $this->input('farm_id', Auth::user()->farm_id);

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('feeds', 'name')
                    ->where(fn ($query) => $query->where('farm_id', $farmId)),
            ],
            'unit' => ['required', 'string', 'max:50'],
            'initial_stock' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    /**
     * Prepare the data for validation.
     * Remove farm_id from the request data so it's never user-supplied;
     * BelongsToTenant trait will set it automatically.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('farm_id') && ! Auth::user()->isSuperAdmin()) {
            $this->request->remove('farm_id');
        }
    }

}
