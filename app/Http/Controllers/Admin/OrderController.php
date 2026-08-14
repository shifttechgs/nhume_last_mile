<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\CreateTaskDTO;
use App\Enums\OrderSource;
use App\Enums\PackageCategory;
use App\Enums\PickupType;
use App\Enums\ServiceType;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TransporterProfile;
use App\Models\User;
use App\Services\ParcelOrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(private readonly ParcelOrderService $orderService) {}

    public function index(Request $request): View
    {
        $query = Task::with(['user', 'assignedDriver.user'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('pickup_address', 'like', "%{$search}%")
                  ->orWhere('dropoff_address', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(25)->withQueryString();

        $counts = collect(TaskStatus::cases())->mapWithKeys(
            fn ($s) => [$s->value => Task::where('status', $s->value)->count()]
        )->toArray();
        $counts['total'] = Task::count();

        return view('admin.orders.index', compact('orders', 'counts'));
    }

    public function create(Request $request): View
    {
        $drivers   = TransporterProfile::with('user')->where('is_active', true)->orderBy('id')->get();
        $customers = User::where('role', UserRole::Sender)->orderBy('name')->get(['id', 'name', 'phone', 'email']);

        $preselectedCustomer = $request->filled('customer_id')
            ? User::find($request->customer_id)
            : null;

        return view('admin.orders.create', compact('drivers', 'customers', 'preselectedCustomer'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_id'      => ['nullable', 'exists:users,id'],
            'sender_name'      => ['required_without:customer_id', 'nullable', 'string', 'max:100'],
            'sender_phone'     => ['nullable', 'string', 'max:20'],
            'pickup_type'      => ['required', 'in:' . implode(',', array_column(PickupType::cases(), 'value'))],
            'pickup_address'   => ['required_if:pickup_type,biker_collection', 'nullable', 'string', 'max:255'],
            'dropoff_address'  => ['required', 'string', 'max:255'],
            'recipient_name'   => ['required', 'string', 'max:100'],
            'recipient_phone'  => ['required', 'string', 'max:20'],
            'package_category' => ['required', 'in:' . implode(',', array_column(PackageCategory::cases(), 'value'))],
            'item_description' => ['nullable', 'string', 'max:255'],
            'weight_kg'        => ['nullable', 'numeric', 'min:0.1', 'max:500'],
            'is_fragile'       => ['boolean'],
            'offered_price'    => ['nullable', 'numeric', 'min:0'],
            'notes'            => ['nullable', 'string', 'max:500'],
            'assigned_driver_id' => ['nullable', 'exists:transporter_profiles,id'],
        ]);

        // Resolve or create customer
        $userId      = $data['customer_id'] ?? null;
        $senderPhone = $data['sender_phone'] ?? null;

        if (!$userId && $data['sender_name']) {
            $phone = $data['sender_phone'] ?? null;
            $email = $phone
                ? preg_replace('/[^0-9a-z]/', '', strtolower($phone)) . '@nhume.local'
                : str()->random(8) . '@nhume.local';

            $customer = User::create([
                'name'     => $data['sender_name'],
                'phone'    => $phone,
                'email'    => $email,
                'password' => bcrypt(str()->random(16)),
                'role'     => UserRole::Sender,
            ]);

            $userId      = $customer->id;
            $senderPhone = $phone;
        }

        $dto = new CreateTaskDTO(
            pickupType:        PickupType::from($data['pickup_type']),
            serviceType:       ServiceType::LastMileDelivery,
            orderSource:       OrderSource::Admin,
            dropoffAddress:    $data['dropoff_address'],
            recipientName:     $data['recipient_name'],
            recipientPhone:    $data['recipient_phone'],
            packageCategory:   PackageCategory::from($data['package_category']),
            collectionPointId: null,
            pickupAddress:     $data['pickup_address'] ?? null,
            itemDescription:   $data['item_description'] ?? null,
            weightKg:          isset($data['weight_kg']) ? (float) $data['weight_kg'] : null,
            isFragile:         (bool) ($data['is_fragile'] ?? false),
            notes:             $data['notes'] ?? null,
            scheduledAt:       null,
            userId:            $userId,
            senderPhone:       $senderPhone,
        );

        $task = $this->orderService->placeOrder($dto);

        // Override price if admin set one
        if (!empty($data['offered_price'])) {
            $task->update(['offered_price' => $data['offered_price'], 'price_estimate' => $data['offered_price']]);
        }

        // Assign driver immediately if selected
        if (!empty($data['assigned_driver_id'])) {
            $task->update([
                'assigned_driver_id' => $data['assigned_driver_id'],
                'status'             => TaskStatus::Assigned,
            ]);
        }

        return redirect()
            ->route('admin.orders.show', $task)
            ->with('success', "Order {$task->order_number} created successfully.");
    }

    public function show(Task $order): View
    {
        $order->load('user', 'assignedDriver.user');

        $availableDrivers = TransporterProfile::with('user')
            ->where('is_active', true)
            ->get();

        return view('admin.orders.show', compact('order', 'availableDrivers'));
    }

    public function updateStatus(Request $request, Task $order): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:' . implode(',', array_column(TaskStatus::cases(), 'value'))],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated.');
    }

    public function assignDriver(Request $request, Task $order): RedirectResponse
    {
        $request->validate([
            'assigned_driver_id' => ['nullable', 'exists:transporter_profiles,id'],
        ]);

        $updates = ['assigned_driver_id' => $request->assigned_driver_id ?: null];

        // Auto-advance status when driver is assigned
        if ($request->assigned_driver_id && $order->status === TaskStatus::Posted) {
            $updates['status'] = TaskStatus::Assigned;
        }

        // Clear assigned status if driver removed
        if (!$request->assigned_driver_id && $order->status === TaskStatus::Assigned) {
            $updates['status'] = TaskStatus::Posted;
        }

        $order->update($updates);

        return back()->with('success', $request->assigned_driver_id
            ? 'Driver assigned — order marked as Assigned.'
            : 'Driver removed.');
    }
}
