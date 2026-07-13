<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreFeedStockLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by policy via parent controller's authorizeResource
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $farmId = Auth::user()->farm_id;

        return [
            'feed_id' => [
                'required',
                'exists:feeds,id',
                Rule::exists('feeds', 'id')->where(fn ($q) => $q->where('farm_id', $farmId)),
            ],
            'type' => ['required', 'string', Rule::in(['in', 'out'])],
            'quantity' => ['required', 'numeric', 'min:0.01'],
            'note' => ['nullable', 'string', 'max:500'],
            'log_date' => ['required', 'date'],
        ];
    }

    /**
     * Configure the validator instance — prevent stock from going negative.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $feed = \App\Models\Feed::find($this->feed_id);

            if (! $feed) {
                return;
            }

            if ($this->type === 'out' && $this->quantity > $feed->current_stock) {
                $validator->errors()->add(
                    'quantity',
                    __('Stok tidak mencukupi. Stok saat ini: :stock, butuh: :qty.', [
                        'stock' => $feed->current_stock,
                        'qty'   => $this->quantity,
                    ])
                );
            }
        });
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
