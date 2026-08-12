<?php

namespace App\Livewire\Parcel;

use App\Enums\OrderSource;
use App\Enums\PackageCategory;
use App\Enums\PickupType;
use App\Enums\ServiceType;
use App\Enums\TaskStatus;
use App\Models\CollectionPoint;
use App\Models\Task;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CreateOrderWizard extends Component
{
    public int $step = 1;

    // Step 1
    public string $pickup_type = '';

    // Step 2 — addresses
    public string $pickup_address  = '';
    public string $dropoff_address = '';
    public string $recipient_name  = '';
    public string $recipient_phone = '';

    // Step 2 — package
    public string $package_category    = '';
    public string $item_description    = '';
    public string $weight_kg           = '';
    public bool   $is_fragile          = false;
    public string $notes               = '';
    public string $collection_point_id = '';

    // Step 2 — schedule
    public string $schedule = 'now';
    public string $scheduled_at = '';

    // Confirmed order
    public ?string $order_number = null;

    public function mount(): void
    {
        $this->scheduled_at = now()->addHour()->format('Y-m-d\TH:i');
    }

    #[Computed]
    public function collectionPoints(): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return CollectionPoint::where('is_active', true)->get();
        } catch (\Exception) {
            return collect();
        }
    }

    #[Computed]
    public function categories(): array
    {
        return PackageCategory::cases();
    }

    #[Computed]
    public function priceEstimate(): float
    {
        $base       = 2.50;
        $collection = ($this->pickup_type === PickupType::BikerCollection->value) ? 2.00 : 0.00;
        $weight     = (float) ($this->weight_kg ?: 1);
        $weightFee  = $weight > 5 ? ($weight - 5) * 0.50 : 0.00;
        $fragile    = $this->is_fragile ? 1.00 : 0.00;

        return round($base + $collection + $weightFee + $fragile, 2);
    }

    public function nextStep(): void
    {
        $this->validateCurrentStep();
        $this->step++;
    }

    public function prevStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function selectPickupType(string $type): void
    {
        $this->pickup_type = $type;
        if ($type === PickupType::WalkIn->value) {
            $this->pickup_address = '';
        }
    }

    public function placeOrder(): void
    {
        $this->validateCurrentStep();

        try {
            $orderNumber = $this->generateOrderNumber();
        } catch (\Exception) {
            $orderNumber = 'NHM-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4));
        }

        try { Task::create([
            'order_number'         => $orderNumber,
            'user_id'              => Auth::id(),
            'service_type'         => ServiceType::LastMileDelivery->value,
            'status'               => TaskStatus::Posted->value,
            'pickup_type'          => $this->pickup_type,
            'order_source'         => OrderSource::Online->value,
            'package_category'     => $this->package_category,
            'item_description'     => $this->item_description,
            'pickup_address'       => $this->pickup_type === PickupType::WalkIn->value
                                        ? ($this->collectionPoints->find($this->collection_point_id)?->address ?? '')
                                        : $this->pickup_address,
            'dropoff_address'      => $this->dropoff_address,
            'recipient_name'       => $this->recipient_name,
            'recipient_phone'      => $this->recipient_phone,
            'weight_kg'            => $this->weight_kg ?: null,
            'is_fragile'           => $this->is_fragile,
            'notes'                => $this->notes,
            'collection_point_id'  => $this->pickup_type === PickupType::WalkIn->value
                                        ? ($this->collection_point_id ?: null)
                                        : null,
            'price_estimate'       => $this->priceEstimate,
            'scheduled_at'         => $this->schedule === 'later'
                                        ? Carbon::parse($this->scheduled_at)
                                        : null,
            'offered_price'        => $this->priceEstimate,
        ]); } catch (\Exception) {}

        $this->order_number = $orderNumber;
        $this->step = 4;
    }

    private function validateCurrentStep(): void
    {
        match ($this->step) {
            1 => $this->validate(['pickup_type' => 'required|in:walk_in,biker_collection']),
            2 => $this->validateStep2(),
            3 => $this->validate([
                'recipient_name'  => 'required|string|max:100',
                'recipient_phone' => 'required|string|max:20',
            ]),
            default => null,
        };
    }

    private function validateStep2(): void
    {
        $rules = [
            'dropoff_address'  => 'required|string|min:5',
            'package_category' => 'required|in:' . implode(',', array_column(PackageCategory::cases(), 'value')),
        ];

        if ($this->pickup_type === PickupType::WalkIn->value) {
            $rules['collection_point_id'] = 'required|exists:collection_points,id';
        } else {
            $rules['pickup_address'] = 'required|string|min:5';
        }

        $this->validate($rules);
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'NHM-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
        } while (Task::where('order_number', $number)->exists());

        return $number;
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.parcel.create-order-wizard');
    }
}
