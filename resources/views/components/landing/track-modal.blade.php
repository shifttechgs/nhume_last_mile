<style>
.track-backdrop {
    position: fixed; inset: 0; z-index: 1000;
    background: rgba(11,19,10,0.62);
    backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
    display: flex; align-items: center; justify-content: center;
    flex-direction: column; gap: 14px;
    padding: 20px;
}
.track-card {
    background: #fff;
    border-radius: 20px;
    width: 100%; max-width: 440px;
    box-shadow:
        0 0 0 1px rgba(0,0,0,0.06),
        0 24px 64px rgba(11,19,10,0.24),
        0 8px 20px rgba(11,19,10,0.1);
    overflow: hidden;
}
.track-card::before {
    content: '';
    display: block;
    height: 3px;
    background: linear-gradient(90deg, #1C3829 0%, #3d7a50 100%);
}
.track-header {
    padding: 22px 22px 0;
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 14px;
}
.track-icon-wrap {
    width: 40px; height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #edf8e4 0%, #d0ead8 100%);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.track-header-text { flex: 1; }
.track-title {
    font-family: 'Inter', 'DM Sans', sans-serif;
    font-size: 17px; font-weight: 700;
    color: #0d1f15;
    letter-spacing: -0.025em;
    margin: 0 0 3px; line-height: 1.3;
}
.track-subtitle { font-size: 13px; color: #6b7280; margin: 0; line-height: 1.5; }
.track-close {
    width: 30px; height: 30px;
    border-radius: 8px; border: none;
    background: #f1f5f9; color: #64748b;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.15s, color 0.15s;
    flex-shrink: 0;
}
.track-close:hover { background: #e2e8f0; color: #0f172a; }
.track-divider { height: 1px; background: #f0f4f8; margin: 18px 22px 0; }
.track-body { padding: 18px 22px 22px; }
.track-input {
    width: 100%; box-sizing: border-box;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px; font-weight: 500;
    color: #0b130a;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 11px;
    padding: 13px 15px;
    outline: none;
    letter-spacing: 0.06em;
    transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
    display: block;
}
.track-input::placeholder { color: #94a3b8; font-weight: 400; letter-spacing: 0.02em; }
.track-input:focus {
    border-color: #1C3829;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(28,56,41,0.1);
}
.track-input:disabled { opacity: 0.55; cursor: not-allowed; }
.track-input.is-error {
    border-color: #f87171;
    background: #fff8f8;
    box-shadow: 0 0 0 3px rgba(248,113,113,0.12);
}
.track-hint {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; color: #94a3b8;
    margin: 8px 0 16px;
}
.track-hint-badge {
    font-family: 'DM Mono', ui-monospace, 'Courier New', monospace;
    font-size: 11px; font-weight: 500;
    color: #475569;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 5px;
    padding: 2px 7px;
    letter-spacing: 0.04em;
}
.track-error-msg {
    font-size: 12px; color: #dc2626;
    margin: 0 0 14px;
    display: flex; align-items: center; gap: 5px;
}
.track-btn {
    width: 100%;
    background: #1C3829;
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px; font-weight: 600;
    padding: 13px 20px;
    border: none; border-radius: 11px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: background 0.18s, box-shadow 0.18s, transform 0.1s;
    box-shadow: 0 1px 3px rgba(28,56,41,0.2), 0 1px 2px rgba(28,56,41,0.08);
    letter-spacing: -0.01em;
}
.track-btn:hover:not(:disabled) {
    background: #152d1f;
    box-shadow: 0 4px 16px rgba(28,56,41,0.28);
}
.track-btn:active:not(:disabled) { transform: scale(0.99); background: #0f2218; }
.track-btn:disabled { opacity: 0.65; cursor: not-allowed; box-shadow: none; }
@keyframes nhume-spin { to { transform: rotate(360deg); } }
.track-spinner { animation: nhume-spin 0.75s linear infinite; }
.track-dismiss {
    font-size: 11.5px; color: rgba(255,255,255,0.4);
    display: flex; align-items: center; gap: 5px;
}
.track-dismiss kbd {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 4px;
    padding: 1px 6px;
    font-family: inherit; font-size: 10.5px;
    color: rgba(255,255,255,0.5);
}
</style>

<div x-show="trackOpen"
     x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click.self="trackOpen = false"
     @keydown.escape.window="trackOpen = false"
     class="track-backdrop">

    <div x-show="trackOpen"
         x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95 translate-y-1"
         class="track-card">

        <div class="track-header">
            <div class="track-icon-wrap">
                <svg width="19" height="19" fill="none" stroke="#1C3829" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="track-header-text">
                <h2 class="track-title">Track your parcel</h2>
                <p class="track-subtitle">Enter your order number to see live delivery updates.</p>
            </div>
            <button type="button" @click="trackOpen = false" class="track-close" aria-label="Close tracking modal">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="track-divider"></div>

        <form class="track-body"
              x-data="{ loading: false, error: false }"
              @submit.prevent="
                  error = false;
                  if (!trackNum.trim()) { error = true; return; }
                  loading = true;
                  window.location = '/track/' + trackNum.trim().toUpperCase();
              ">

            <input x-model="trackNum"
                   x-ref="trackInput"
                   type="text"
                   placeholder="e.g. NHM-20260812-XXXX"
                   autocomplete="off"
                   spellcheck="false"
                   :disabled="loading"
                   class="track-input"
                   :class="{ 'is-error': error }"
                   @input="error = false">

            <div class="track-hint">
                Format: <span class="track-hint-badge">NHM-YYYYMMDD-XXXX</span>
            </div>

            <p x-show="error" class="track-error-msg" x-cloak>
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v4m0 4h.01"/>
                </svg>
                Please enter an order number to continue.
            </p>

            <button type="submit" :disabled="loading" class="track-btn">
                <svg x-show="loading" class="track-spinner" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <svg x-show="!loading" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                </svg>
                <span x-text="loading ? 'Looking up order…' : 'Track parcel'"></span>
            </button>
        </form>
    </div>

    <p class="track-dismiss">Press <kbd>Esc</kbd> to dismiss</p>
</div>
