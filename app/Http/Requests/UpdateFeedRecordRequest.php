<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateFeedRecordRequest extends FormRequest
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
     * When updating a FeedRecord, we need to check if the new quantity causes stock to go negative.
     */
    public function withValidator($validator): void
    {
        $feedId = $this->input('feed_id');
        $quantity = $this->input('quantity');
        $feedRecord = $this->route('feedRecord');

        $validator->after(function ($validator) use ($feedId, $quantity, $feedRecord) {
            if (! $feedId || ! $quantity || ! $feedRecord) {
                return;
            }

            /** @var \App\Models\Feed|null $feed */
            $feed = \App\Models\Feed::find($feedId);

            if (! $feed) {
                return;
            }

            // Calculate stock impact: current_stock + old_quantity - new_quantity
            // Old FeedStockLog will be deleted (returns old_quantity to stock)
            // New FeedStockLog will be created (deducts new_quantity from stock)
            $oldQuantity = $feedRecord->quantity;
            $stockAfterUpdate = $feed->current_stock + $oldQuantity - $quantity;

            if ($stockAfterUpdate < 0) {
                $validator->errors()->add(
                    'quantity',
                    __('Stok pakan tidak mencukupi. Stok :feed saat ini: :stock :unit, setelah update akan jadi: :after :unit (negatif).', [
                        'feed'  => $feed->name,
                        'stock' => number_format($feed->current_stock, 2),
                        'after' => number_format($stockAfterUpdate, 2),
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
