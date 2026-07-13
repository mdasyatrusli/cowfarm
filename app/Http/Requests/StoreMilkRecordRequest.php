<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMilkRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
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
            'cow_id' => ['required', 'exists:cows,id'],
            'record_date' => ['required', 'date'],
            'session' => ['required', 'in:pagi,sore'],
            'volume_liters' => ['required', 'numeric', 'min:0'],
        ];
    }
}
