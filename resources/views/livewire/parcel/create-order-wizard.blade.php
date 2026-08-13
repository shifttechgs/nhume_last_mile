<div>

    {{-- ══ CONFIRMATION (step 3) — full width ══ --}}
    @if($step === 3)
    <div class="wiz-confirm">
        <div class="wiz-confirm-icon">
            <svg width="28" height="28" fill="none" stroke="#4a9a1f" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h2 class="wiz-confirm-title">Order placed!</h2>
        <p class="wiz-confirm-sub">Your parcel is registered. Use the order number below to track it.</p>

        <div class="wiz-order-box">
            <span class="wiz-order-label">Order number</span>
            <span class="wiz-order-num">{{ $order_number }}</span>
            <button type="button"
                x-data
                x-on:click="navigator.clipboard.writeText('{{ $order_number }}').then(() => { $el.textContent = 'Copied!'; setTimeout(() => $el.textContent = 'Copy', 1500) })"
                class="wiz-order-copy">Copy</button>
        </div>

        <div class="wiz-next-step">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @if($pickup_type === 'walk_in')
                Drop your parcel at the shop and quote your order number. Our team will take it from there.
            @else
                A biker will be dispatched to your pickup address. You will be notified when they are on their way.
            @endif
        </div>

        <div class="wiz-confirm-actions">
            <a href="{{ route('track', $order_number) }}" class="btn-wiz-primary">Track my parcel</a>
            <button type="button" wire:click="$set('step', 1)" class="btn-wiz-ghost">Send another</button>
        </div>
    </div>
    @endif

    {{-- ══ STEPS 1 + 2 — two-column layout ══ --}}
    @if($step < 3)
    <div class="wiz-layout">

        {{-- ── LEFT: stepper form ── --}}
        <div class="wiz-left">

            {{-- Progress indicator --}}
            <div class="wiz-progress">
                @foreach(['How?' => 1, 'Details' => 2] as $label => $num)
                <div class="wiz-prog-step {{ $step >= $num ? ($step > $num ? 'done' : 'active') : '' }}">
                    <div class="wiz-prog-dot">
                        @if($step > $num)
                            <svg width="11" height="11" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        @else
                            {{ $num }}
                        @endif
                    </div>
                    <span class="wiz-prog-label">{{ $label }}</span>
                </div>
                @if($num < 2)<div class="wiz-prog-line {{ $step > $num ? 'done' : '' }}"></div>@endif
                @endforeach
            </div>

            {{-- ─ STEP 1: How? ─ --}}
            @if($step === 1)
            <div class="wiz-card">
                <div class="wiz-card-head">
                    <h2 class="wiz-title">How are you sending?</h2>
                    <p class="wiz-sub">Choose how your parcel gets to us.</p>
                </div>

                <div class="wiz-card-body">
                    {{--
                        Alpine manages the visual state (instant feedback on click).
                        @entangle keeps it in sync with Livewire so the summary updates.
                    --}}
                    <div class="pickup-cards"
                         x-data="{ pickupType: @entangle('pickup_type').live }">

                        @foreach([
                            ['value' => 'walk_in',          'title' => 'Drop at shop',   'desc' => 'Bring your parcel to the nearest Nhume shop.', 'badge' => 'Free drop-off',        'badge_cls' => '',          'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                            ['value' => 'biker_collection', 'title' => 'Biker picks up', 'desc' => 'We send a biker to collect from your address.',  'badge' => '+$2.00 collection fee', 'badge_cls' => 'collection', 'icon' => 'M12 4l-1 6h6l-3 5M5 18l4-5h2'],
                        ] as $opt)
                        <label class="pickup-card"
                               :class="{ 'selected': pickupType === '{{ $opt['value'] }}' }"
                               @click="pickupType = '{{ $opt['value'] }}'">
                            <input type="radio" name="pickup_type" value="{{ $opt['value'] }}"
                                   x-model="pickupType"
                                   style="position:absolute;opacity:0;pointer-events:none;">
                            <div class="pickup-icon">
                                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $opt['icon'] }}"/></svg>
                            </div>
                            <div class="pickup-body">
                                <span class="pickup-title">{{ $opt['title'] }}</span>
                                <span class="pickup-desc">{{ $opt['desc'] }}</span>
                                <span class="pickup-badge {{ $opt['badge_cls'] }}">{{ $opt['badge'] }}</span>
                            </div>
                            <div class="pickup-check" :class="{ 'on': pickupType === '{{ $opt['value'] }}' }">
                                <svg width="12" height="12" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('pickup_type')<p class="field-err">Please select how you are sending.</p>@enderror
                </div>

                <div class="wiz-card-foot">
                    <button type="button" wire:click="nextStep"
                            wire:loading.attr="disabled" wire:target="nextStep"
                            class="btn-wiz-primary">
                        <span wire:loading.remove wire:target="nextStep" class="btn-label">
                            Next
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                        <span wire:loading wire:target="nextStep">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="animation:spin 0.8s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </span>
                    </button>
                </div>
            </div>
            @endif

            {{-- ─ STEP 2: Details ─ --}}
            @if($step === 2)
            <div class="wiz-card">
                <div class="wiz-card-head">
                    <button type="button" wire:click="prevStep" class="wiz-back">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                        Back
                    </button>
                    <h2 class="wiz-title">Parcel details</h2>
                    <p class="wiz-sub">Tell us what you are sending and where.</p>
                </div>

                <div class="wiz-card-body">
                    <div class="fields">

                        {{-- Shop selector (walk-in) --}}
                        @if($pickup_type === 'walk_in')
                        <div class="field">
                            <label class="flabel">Drop-off shop</label>
                            @if($this->collectionPoints->isEmpty())
                                <p class="field-hint">No collection points available yet.</p>
                            @else
                            <select wire:model="collection_point_id" class="finput">
                                <option value="">Select a Nhume shop</option>
                                @foreach($this->collectionPoints as $cp)
                                    <option value="{{ $cp->id }}">{{ $cp->name }} — {{ $cp->address }}</option>
                                @endforeach
                            </select>
                            @error('collection_point_id')<p class="field-err">{{ $message }}</p>@enderror
                            @endif
                        </div>
                        @endif

                        {{-- Pickup address (biker) --}}
                        @if($pickup_type === 'biker_collection')
                        <div class="field">
                            <label class="flabel">Pickup address</label>
                            <input wire:model.blur="pickup_address" type="text" class="finput" placeholder="Where should the biker collect from?">
                            @error('pickup_address')<p class="field-err">{{ $message }}</p>@enderror
                        </div>
                        @endif

                        {{-- Delivery address --}}
                        <div class="field">
                            <label class="flabel">Delivery address</label>
                            <input wire:model.blur="dropoff_address" type="text" class="finput" placeholder="Where is it going?">
                            @error('dropoff_address')<p class="field-err">{{ $message }}</p>@enderror
                        </div>

                        {{-- Category --}}
                        <div class="field">
                            <label class="flabel">What are you sending?</label>
                            <div class="chips" x-data="{ cat: @entangle('package_category') }">
                                @foreach($this->categories as $cat)
                                <button type="button"
                                    @click="cat = '{{ $cat->value }}'"
                                    :class="{ 'on': cat === '{{ $cat->value }}' }"
                                    class="chip">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cat->icon() }}"/></svg>
                                    {{ $cat->label() }}
                                </button>
                                @endforeach
                            </div>
                            @error('package_category')<p class="field-err">{{ $message }}</p>@enderror
                        </div>

                        {{-- Weight + fragile --}}
                        <div class="field-row">
                            <div class="field" style="flex:1">
                                <label class="flabel">Weight (kg) <span class="fopt">optional</span></label>
                                <input wire:model.blur="weight_kg" type="number" step="0.1" min="0" class="finput" placeholder="e.g. 1.5">
                            </div>
                            <div class="field" style="flex:1;display:flex;flex-direction:column;justify-content:flex-end;">
                                <label class="flabel">&nbsp;</label>
                                <label class="toggle">
                                    <input wire:model.live="is_fragile" type="checkbox" style="display:none;">
                                    <span class="toggle-track"><span class="toggle-thumb"></span></span>
                                    <span class="toggle-lbl">Fragile item</span>
                                </label>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="field">
                            <label class="flabel">Instructions <span class="fopt">optional</span></label>
                            <textarea wire:model="notes" class="finput" rows="2" placeholder="Any special handling notes..."></textarea>
                        </div>

                        {{-- Schedule --}}
                        <div class="field">
                            <label class="flabel">When?</label>
                            <div style="display:flex;gap:8px;">
                                <button type="button" wire:click="$set('schedule','now')" class="sched-btn {{ $schedule==='now' ? 'on' : '' }}">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/></svg>
                                    Now
                                </button>
                                <button type="button" wire:click="$set('schedule','later')" class="sched-btn {{ $schedule==='later' ? 'on' : '' }}">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Schedule
                                </button>
                            </div>
                            @if($schedule === 'later')
                            <input wire:model="scheduled_at" type="datetime-local" class="finput" style="margin-top:10px;"
                                min="{{ now()->addMinutes(30)->format('Y-m-d\TH:i') }}">
                            @endif
                        </div>

                        {{-- Recipient --}}
                        <div class="field-section-label">Recipient</div>
                        <div class="field-row">
                            <div class="field" style="flex:1">
                                <label class="flabel">Full name</label>
                                <input wire:model.blur="recipient_name" type="text" class="finput" placeholder="Recipient's name">
                                @error('recipient_name')<p class="field-err">{{ $message }}</p>@enderror
                            </div>
                            <div class="field" style="flex:1">
                                <label class="flabel">Phone</label>
                                <input wire:model.blur="recipient_phone" type="tel" class="finput" placeholder="+263...">
                                @error('recipient_phone')<p class="field-err">{{ $message }}</p>@enderror
                            </div>
                        </div>

                    </div>
                </div>

                <div class="wiz-card-foot" style="justify-content:space-between;">
                    <button type="button" wire:click="prevStep" class="btn-wiz-ghost">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                        Back
                    </button>
                    <span style="font-size:12.5px;color:var(--text-2);align-self:center;">Use the panel to place your order →</span>
                </div>
            </div>
            @endif

        </div>{{-- /wiz-left --}}

        {{-- ── RIGHT: live order summary ── --}}
        <div class="wiz-right">
            <div class="summary-card">
                <h3 class="summary-title">Order summary</h3>

                <div class="summary-rows">

                    {{-- Pickup method --}}
                    <div class="srow">
                        <span class="skey">Pickup</span>
                        <span class="sval {{ !$pickup_type ? 'empty' : '' }}">
                            {{ $pickup_type ? ($pickup_type === 'walk_in' ? 'Drop at shop' : 'Biker picks up') : '—' }}
                        </span>
                    </div>

                    {{-- From --}}
                    @if($pickup_type === 'biker_collection')
                    <div class="srow">
                        <span class="skey">From</span>
                        <span class="sval {{ !$pickup_address ? 'empty' : '' }}">{{ $pickup_address ?: '—' }}</span>
                    </div>
                    @endif

                    {{-- To --}}
                    <div class="srow">
                        <span class="skey">To</span>
                        <span class="sval {{ !$dropoff_address ? 'empty' : '' }}">{{ $dropoff_address ?: '—' }}</span>
                    </div>

                    {{-- Item --}}
                    <div class="srow">
                        <span class="skey">Item</span>
                        <span class="sval {{ !$package_category ? 'empty' : '' }}">
                            {{ $package_category ? ucfirst($package_category) : '—' }}
                            @if($weight_kg) · {{ $weight_kg }} kg @endif
                        </span>
                    </div>

                    {{-- When --}}
                    <div class="srow">
                        <span class="skey">When</span>
                        <span class="sval">
                            {{ $schedule === 'later' && $scheduled_at ? \Carbon\Carbon::parse($scheduled_at)->format('D d M, H:i') : 'As soon as possible' }}
                        </span>
                    </div>

                    {{-- Recipient --}}
                    @if($recipient_name || $recipient_phone)
                    <div class="srow">
                        <span class="skey">Recipient</span>
                        <span class="sval">{{ $recipient_name }}{{ $recipient_phone ? ' · ' . $recipient_phone : '' }}</span>
                    </div>
                    @endif

                </div>

                {{-- Price breakdown --}}
                <div class="summary-price">
                    <div class="price-line">
                        <span>Base delivery</span>
                        <span>$2.50</span>
                    </div>
                    @if($pickup_type === 'biker_collection')
                    <div class="price-line">
                        <span>Collection fee</span>
                        <span>$2.00</span>
                    </div>
                    @endif
                    @if($is_fragile)
                    <div class="price-line">
                        <span>Fragile handling</span>
                        <span>$1.00</span>
                    </div>
                    @endif
                    <div class="price-total">
                        <span>Estimated total</span>
                        <span>${{ number_format($this->priceEstimate, 2) }}</span>
                    </div>
                </div>

                {{-- CTA --}}
                <div class="summary-cta">
                    <button type="button"
                            wire:click="placeOrder"
                            wire:loading.attr="disabled" wire:target="placeOrder"
                            @disabled($step < 2)
                            class="btn-wiz-primary" style="width:100%;">
                        <span wire:loading.remove wire:target="placeOrder" class="btn-label">
                            Place order
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span wire:loading wire:target="placeOrder" class="btn-label">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="animation:spin 0.8s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Placing order...
                        </span>
                    </button>
                    <p class="summary-note">No payment now. You pay on delivery.</p>
                </div>

            </div>
        </div>

    </div>
    @endif

</div>
