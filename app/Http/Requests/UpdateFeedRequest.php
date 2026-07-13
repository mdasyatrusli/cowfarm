<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateFeedRequest extends FormRequest
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
        /** @var \App\Models\Feed $feed */
        $feed = $this->route('feed');
        $farmId = $this->input('farm_id', Auth::user()->farm_id);

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('feeds', 'name')
                    ->where(fn ($query) => $query->where('farm_id', $farmId))
                    ->ignore($feed),
            ],
            'unit' => ['required', 'string', 'max:50'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('farm_id') && ! Auth::user()->isSuperAdmin()) {
            $this->request->remove('farm_id');
        }
    }
}
