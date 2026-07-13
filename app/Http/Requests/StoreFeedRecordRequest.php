<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreFeedRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by FeedRecordPolicy via authorizeResource
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
            'cow_id' => [
                'required',
                'exists:cows,id',
                Rule::exists('cows', 'id')->where(fn ($q) => $q->where('farm_id', $farmId)),
            ],
            'feed_id' => [
                'required',
                'exists:feeds,id',
                Rule::exists('feeds', 'id')->where(fn ($q) => $q->where('farm_id', $farmId)),
            ],
            'record_date' => ['required', 'date'],
            'quantity' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    /**
     * Configure the validator instance — prevent stock from going negative.
     * FeedRecord creates a FeedStockLog (type=out) via booted() hook,
     * so we must check stock availability before creating the record.
     */
    public function withValidator($validator): void
    {
        $feedId = $this->input('feed_id');
        $quantity = $this->input('quantity');

        $validator->after(function ($validator) use ($feedId, $quantity) {
            if (! $feedId || ! $quantity) {
                return;
            }

            /** @var \App\Models\Feed|null $feed */
            $feed = \App\Models\Feed::find($feedId);

            if (! $feed) {
                return;
            }

            if ($quantity > $feed->current_stock) {
                $validator->errors()->add(
                    'quantity',
                    __('Stok pakan tidak mencukupi. Stok :feed saat ini: :stock :unit, yang diminta: :qty :unit.', [
                        'feed'  => $feed->name,
                        'stock' => number_format($feed->current_stock, 2),
                        'qty'   => number_format($quantity, 2),
                        'unit'  => $feed->unit,
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
