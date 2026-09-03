<?php

declare(strict_types=1);

namespace App\Livewire\Parcel;

use App\DTOs\CreateTaskDTO;
use App\Enums\OrderSource;
use App\Enums\PackageCategory;
use App\Enums\PickupType;
use App\Enums\ServiceType;
use App\Services\ParcelOrderService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class CreateOrderWizard extends Component
{
    public int $step = 1;

    // Step 1
    public string $pickup_type = '';

    // Step 2 — addresses
    public string $pickup_address  = '';
    public string $dropoff_address = '';
    public string $sender_phone    = '';
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
    public string $schedule    = 'now';
    public string $scheduled_at = '';

    // Confirmed order
    public ?string $order_number = null;

    private ParcelOrderService $orderService;

    public function boot(ParcelOrderService $orderService): void
    {
        $this->orderService = $orderService;
    }

    public function mount(): void
    {
        $this->scheduled_at = now()->addHour()->format('Y-m-d\TH:i');

        // Prefill addresses from the homepage quote-starter (low-friction entry)
        $this->pickup_address  = trim((string) request('pickup', ''));
        $this->dropoff_address = trim((string) request('dropoff', ''));
    }

    #[Computed(persist: true)]
    public function collectionPoints(): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return \App\Models\CollectionPoint::where('is_active', true)->get();
        } catch (\Exception) {
            return \App\Models\CollectionPoint::query()->whereRaw('0=1')->get();
        }
    }

    #[Computed]
    public function categories(): array
    {
        return PackageCategory::cases();
    }

    /**
     * Live price preview — mirrors CalculateTaskPriceAction constants.
     * The actual persisted price is calculated by the action on placeOrder.
     */
    #[Computed]
    public function priceEstimate(): float
    {
        $price = 2.50;

        if ($this->pickup_type === PickupType::BikerCollection->value) {
            $price += 2.00;
        }

        $weight = (float) ($this->weight_kg ?: 0);
        if ($weight > 5) {
            $price += ($weight - 5) * 0.50;
        }

        if ($this->is_fragile) {
            $price += 1.00;
        }

        return round($price, 2);
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

    public function placeOrder(): void
    {
        $this->validateCurrentStep();

        $pickupType = PickupType::from($this->pickup_type);

        $dto = new CreateTaskDTO(
            pickupType:        $pickupType,
            serviceType:       ServiceType::LastMileDelivery,
            orderSource:       OrderSource::Online,
            dropoffAddress:    $this->dropoff_address,
            recipientName:     $this->recipient_name,
            recipientPhone:    $this->recipient_phone,
            packageCategory:   PackageCategory::from($this->package_category),
            collectionPointId: $pickupType === PickupType::WalkIn
                                   ? (int) $this->collection_point_id ?: null
                                   : null,
            pickupAddress:     $pickupType === PickupType::WalkIn
                                   ? ($this->collectionPoints->find($this->collection_point_id)?->address ?? '')
                                   : $this->pickup_address,
            itemDescription:   $this->item_description ?: null,
            weightKg:          $this->weight_kg !== '' ? (float) $this->weight_kg : null,
            isFragile:         $this->is_fragile,
            notes:             $this->notes ?: null,
            scheduledAt:       $this->schedule === 'later'
                                   ? Carbon::parse($this->scheduled_at)
                                   : null,
            userId:            Auth::id(),
            senderPhone:       $this->sender_phone ?: null,
        );

        $task = $this->orderService->placeOrder($dto);

        $this->order_number = $task->order_number;
        $this->step = 3;
    }

    private function validateCurrentStep(): void
    {
        match ($this->step) {
            1 => $this->validate(['pickup_type' => 'required|in:walk_in,biker_collection']),
            2 => $this->validateStep2(),
            default => null,
        };
    }

    private function validateStep2(): void
    {
        $rules = [
            'dropoff_address'  => 'required|string|min:5',
            'package_category' => 'required|in:' . implode(',', array_column(PackageCategory::cases(), 'value')),
            'recipient_name'   => 'required|string|max:100',
            'recipient_phone'  => 'required|string|max:20',
        ];

        if ($this->pickup_type === PickupType::WalkIn->value) {
            $rules['collection_point_id'] = 'required|exists:collection_points,id';
        } else {
            $rules['pickup_address'] = 'required|string|min:5';
        }

        $this->validate($rules);
    }

    public function render(): View
    {
        return view('livewire.parcel.create-order-wizard');
    }
}
