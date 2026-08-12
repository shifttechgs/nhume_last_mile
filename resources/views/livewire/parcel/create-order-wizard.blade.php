<div class="wizard-wrap" x-data>

    {{-- Progress bar --}}
    @if($step < 4)
    <div class="wizard-progress">
        @foreach(['How?', 'Details', 'Confirm'] as $i => $label)
            <div class="wizard-step {{ $step > $i ? 'done' : ($step === $i + 1 ? 'active' : '') }}">
                <div class="wizard-step-dot">
                    @if($step > $i + 1)
                        <svg width="12" height="12" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    @else
                        {{ $i + 1 }}
                    @endif
                </div>
                <span class="wizard-step-label">{{ $label }}</span>
            </div>
            @if($i < 2)<div class="wizard-step-line {{ $step > $i + 1 ? 'done' : '' }}"></div>@endif
        @endforeach
    </div>
    @endif

    {{-- ══ STEP 1 — Pickup type ══ --}}
    @if($step === 1)
    <div class="wizard-body">
        <h2 class="wizard-title">How are you sending?</h2>
        <p class="wizard-sub">Choose how your parcel gets to us.</p>

        <div class="pickup-cards">
            @foreach([
                ['value' => 'walk_in',          'title' => 'Drop at shop',   'desc' => 'Bring your parcel to the nearest Nhume shop.', 'badge' => 'Free drop-off', 'badge_class' => '', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ['value' => 'biker_collection', 'title' => 'Biker picks up', 'desc' => 'We send a biker to collect from your address.', 'badge' => '+$2.00 collection fee', 'badge_class' => 'collection', 'icon' => 'M12 4l-1 6h6l-3 5M5 18l4-5h2'],
            ] as $opt)
            <label class="pickup-card {{ $pickup_type === $opt['value'] ? 'selected' : '' }}" style="cursor:pointer;">
                <input type="radio" wire:model.live="pickup_type" value="{{ $opt['value'] }}" style="position:absolute;opacity:0;pointer-events:none;">
                <div class="pickup-card-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $opt['icon'] }}"/></svg>
                </div>
                <div class="pickup-card-body">
                    <span class="pickup-card-title">{{ $opt['title'] }}</span>
                    <span class="pickup-card-desc">{{ $opt['desc'] }}</span>
                    <span class="pickup-card-badge {{ $opt['badge_class'] }}">{{ $opt['badge'] }}</span>
                </div>
                <div class="pickup-card-check {{ $pickup_type === $opt['value'] ? 'visible' : '' }}">
                    <svg width="14" height="14" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
            </label>
            @endforeach
        </div>

        @error('pickup_type')<p class="field-error">Please select how you are sending.</p>@enderror

        <div class="wizard-actions">
            <button type="button" wire:click="nextStep" class="btn-wizard-primary">
                Continue
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </button>
        </div>
    </div>
    @endif

    {{-- ══ STEP 2 — Details ══ --}}
    @if($step === 2)
    <div class="wizard-body">
        <h2 class="wizard-title">Parcel details</h2>
        <p class="wizard-sub">Tell us what you are sending and where it is going.</p>

        <div class="wizard-fields">

            {{-- Walk-in: choose shop --}}
            @if($pickup_type === 'walk_in')
            <div class="field-group">
                <label class="field-label">Drop-off shop</label>
                @if($this->collectionPoints->isEmpty())
                    <p class="field-hint" style="color:#e57373;">No collection points available yet. Check back soon.</p>
                @else
                <select wire:model="collection_point_id" class="field-input">
                    <option value="">Select a Nhume shop</option>
                    @foreach($this->collectionPoints as $cp)
                        <option value="{{ $cp->id }}">{{ $cp->name }} — {{ $cp->address }}</option>
                    @endforeach
                </select>
                @error('collection_point_id')<p class="field-error">{{ $message }}</p>@enderror
                @endif
            </div>
            @endif

            {{-- Biker: pickup address --}}
            @if($pickup_type === 'biker_collection')
            <div class="field-group">
                <label class="field-label">Pickup address</label>
                <input wire:model.live="pickup_address" type="text" class="field-input" placeholder="Where should the biker collect from?">
                @error('pickup_address')<p class="field-error">{{ $message }}</p>@enderror
            </div>
            @endif

            {{-- Delivery address --}}
            <div class="field-group">
                <label class="field-label">Delivery address</label>
                <input wire:model.live="dropoff_address" type="text" class="field-input" placeholder="Where is it going?">
                @error('dropoff_address')<p class="field-error">{{ $message }}</p>@enderror
            </div>

            {{-- Package category --}}
            <div class="field-group">
                <label class="field-label">What are you sending?</label>
                <div class="category-chips">
                    @foreach($this->categories as $cat)
                    <button type="button"
                        wire:click="$set('package_category', '{{ $cat->value }}')"
                        class="category-chip {{ $package_category === $cat->value ? 'selected' : '' }}">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cat->icon() }}"/></svg>
                        {{ $cat->label() }}
                    </button>
                    @endforeach
                </div>
                @error('package_category')<p class="field-error">{{ $message }}</p>@enderror
            </div>

            {{-- Weight + fragile --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="field-group" style="margin:0">
                    <label class="field-label">Weight (kg) <span class="field-optional">optional</span></label>
                    <input wire:model.live="weight_kg" type="number" step="0.1" min="0" class="field-input" placeholder="e.g. 1.5">
                </div>
                <div class="field-group" style="margin:0;display:flex;flex-direction:column;justify-content:flex-end;">
                    <label class="field-label">&nbsp;</label>
                    <label class="toggle-wrap">
                        <input wire:model.live="is_fragile" type="checkbox" class="toggle-input">
                        <span class="toggle-track">
                            <span class="toggle-thumb"></span>
                        </span>
                        <span class="toggle-label">Fragile item</span>
                    </label>
                </div>
            </div>

            {{-- Notes --}}
            <div class="field-group">
                <label class="field-label">Instructions <span class="field-optional">optional</span></label>
                <textarea wire:model="notes" class="field-input" rows="2" placeholder="Any special handling notes..."></textarea>
            </div>

            {{-- Schedule --}}
            <div class="field-group">
                <label class="field-label">When?</label>
                <div style="display:flex;gap:10px;">
                    <button type="button" wire:click="$set('schedule','now')"
                        class="schedule-btn {{ $schedule === 'now' ? 'selected' : '' }}">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/></svg>
                        Now
                    </button>
                    <button type="button" wire:click="$set('schedule','later')"
                        class="schedule-btn {{ $schedule === 'later' ? 'selected' : '' }}">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Schedule
                    </button>
                </div>
                @if($schedule === 'later')
                <input wire:model="scheduled_at" type="datetime-local" class="field-input" style="margin-top:10px;"
                    min="{{ now()->addMinutes(30)->format('Y-m-d\TH:i') }}">
                @endif
            </div>

            {{-- Live price estimate --}}
            <div class="price-estimate-bar">
                <div>
                    <span class="price-label">Estimated price</span>
                    @if($is_fragile)
                        <span class="price-hint">Includes $1.00 fragile handling</span>
                    @endif
                    @if($pickup_type === 'biker_collection')
                        <span class="price-hint">Includes $2.00 collection fee</span>
                    @endif
                </div>
                <span class="price-value">${{ number_format($this->priceEstimate, 2) }}</span>
            </div>
        </div>

        <div class="wizard-actions">
            <button type="button" wire:click="prevStep" class="btn-wizard-ghost">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                Back
            </button>
            <button type="button" wire:click="nextStep" class="btn-wizard-primary">
                Review order
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </button>
        </div>
    </div>
    @endif

    {{-- ══ STEP 3 — Confirm ══ --}}
    @if($step === 3)
    <div class="wizard-body">
        <h2 class="wizard-title">Review your order</h2>
        <p class="wizard-sub">Check everything before placing.</p>

        <div class="review-card">
            {{-- Pickup method --}}
            <div class="review-row">
                <span class="review-key">Pickup</span>
                <span class="review-val">
                    {{ $pickup_type === 'walk_in' ? 'Drop at shop' : 'Biker collection' }}
                </span>
                <button type="button" wire:click="$set('step', 1)" class="review-edit">Edit</button>
            </div>

            @if($pickup_type === 'walk_in' && $collection_point_id)
            <div class="review-row">
                <span class="review-key">Shop</span>
                <span class="review-val">{{ $this->collectionPoints->find($collection_point_id)?->name }}</span>
                <button type="button" wire:click="$set('step', 2)" class="review-edit">Edit</button>
            </div>
            @endif

            @if($pickup_type === 'biker_collection')
            <div class="review-row">
                <span class="review-key">Pickup address</span>
                <span class="review-val">{{ $pickup_address }}</span>
                <button type="button" wire:click="$set('step', 2)" class="review-edit">Edit</button>
            </div>
            @endif

            <div class="review-row">
                <span class="review-key">Deliver to</span>
                <span class="review-val">{{ $dropoff_address }}</span>
                <button type="button" wire:click="$set('step', 2)" class="review-edit">Edit</button>
            </div>

            <div class="review-row">
                <span class="review-key">Item</span>
                <span class="review-val">{{ ucfirst($package_category) }}{{ $item_description ? ' — ' . $item_description : '' }}</span>
                <button type="button" wire:click="$set('step', 2)" class="review-edit">Edit</button>
            </div>

            @if($weight_kg)
            <div class="review-row">
                <span class="review-key">Weight</span>
                <span class="review-val">{{ $weight_kg }} kg</span>
                <span></span>
            </div>
            @endif

            @if($is_fragile)
            <div class="review-row">
                <span class="review-key">Handling</span>
                <span class="review-val" style="color:#e57373;">Fragile</span>
                <span></span>
            </div>
            @endif

            <div class="review-row">
                <span class="review-key">When</span>
                <span class="review-val">
                    {{ $schedule === 'now' ? 'As soon as possible' : \Carbon\Carbon::parse($scheduled_at)->format('D d M, H:i') }}
                </span>
                <button type="button" wire:click="$set('step', 2)" class="review-edit">Edit</button>
            </div>

            <div class="review-divider"></div>

            <div class="review-row" style="font-weight:700;">
                <span class="review-key" style="font-weight:700;color:#1C3829;">Estimated total</span>
                <span class="review-val" style="font-size:20px;color:#1C3829;">${{ number_format($this->priceEstimate, 2) }}</span>
                <span></span>
            </div>
        </div>

        {{-- Recipient details --}}
        <div class="wizard-fields" style="margin-top:24px;">
            <h3 style="font-size:14px;font-weight:700;color:#1C3829;margin:0 0 16px;">Recipient details</h3>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div class="field-group" style="margin:0">
                    <label class="field-label">Full name</label>
                    <input wire:model="recipient_name" type="text" class="field-input" placeholder="Recipient's name">
                    @error('recipient_name')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div class="field-group" style="margin:0">
                    <label class="field-label">Phone number</label>
                    <input wire:model="recipient_phone" type="tel" class="field-input" placeholder="+263...">
                    @error('recipient_phone')<p class="field-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="wizard-actions">
            <button type="button" wire:click="prevStep" class="btn-wizard-ghost">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                Back
            </button>
            <button type="button" wire:click="placeOrder" wire:loading.attr="disabled" class="btn-wizard-primary">
                <span wire:loading.remove>
                    Place order
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </span>
                <span wire:loading>Placing order...</span>
            </button>
        </div>
    </div>
    @endif

    {{-- ══ STEP 4 — Confirmation ══ --}}
    @if($step === 4)
    <div class="wizard-body" style="text-align:center;padding:60px 40px;">
        <div style="width:64px;height:64px;border-radius:50%;background:#edf8df;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
            <svg width="28" height="28" fill="none" stroke="#4a9a1f" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>

        <h2 style="font-family:'General Sans',sans-serif;font-size:26px;font-weight:700;color:#1C3829;margin:0 0 10px;">Order placed!</h2>
        <p style="font-size:15px;color:#5f6560;margin:0 0 32px;">Your parcel is registered. Use the order number below to track it.</p>

        <div class="order-number-display">
            <span class="order-number-label">Order number</span>
            <span class="order-number-value">{{ $order_number }}</span>
            <button type="button"
                x-on:click="navigator.clipboard.writeText('{{ $order_number }}').then(() => { $el.textContent = 'Copied!'; setTimeout(() => $el.textContent = 'Copy', 1500) })"
                class="order-number-copy">Copy</button>
        </div>

        @if($pickup_type === 'walk_in')
        <div class="order-next-step">
            <svg width="18" height="18" fill="none" stroke="#4a9a1f" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Drop your parcel at the shop and quote your order number. Our team will take it from there.
        </div>
        @else
        <div class="order-next-step">
            <svg width="18" height="18" fill="none" stroke="#4a9a1f" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            A biker will be dispatched to your pickup address. You'll be notified when they are on their way.
        </div>
        @endif

        <div style="margin-top:32px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <a href="/track/{{ $order_number }}" class="btn-wizard-primary">Track parcel</a>
            <button type="button" wire:click="$set('step', 1), $set('pickup_type', ''), $set('order_number', null)" class="btn-wizard-ghost">Send another</button>
        </div>
    </div>
    @endif

</div>
