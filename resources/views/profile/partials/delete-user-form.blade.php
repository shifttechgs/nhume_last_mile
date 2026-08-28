<section x-data="{ open: false }">

    <p class="text-sm text-gray-500 mb-5 max-w-md">
        Once your account is deleted, all data will be permanently removed. This cannot be undone.
    </p>

    <button type="button" @click="open = true"
            style="background:#dc2626;color:#fff;font-size:13.5px;font-weight:600;padding:9px 20px;border:none;border-radius:6px;cursor:pointer;transition:background 0.15s;"
            onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
        Delete account
    </button>

    {{-- Confirmation modal --}}
    <div x-show="open" x-cloak
         style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;padding:20px;">

        {{-- Backdrop --}}
        <div @click="open = false"
             style="position:absolute;inset:0;background:rgba(0,0,0,0.45);"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>

        {{-- Dialog --}}
        <div style="position:relative;z-index:1;background:#fff;border:1px solid #e5e7eb;border-radius:8px;padding:28px;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,0.15);"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <h3 style="font-size:16px;font-weight:700;color:#111827;margin:0 0 8px;">Delete your account?</h3>
            <p style="font-size:13.5px;color:#6b7280;line-height:1.6;margin:0 0 20px;">
                This is permanent. All your data will be deleted immediately. Enter your password to confirm.
            </p>

            <form method="post" action="{{ route('profile.destroy') }}"
                  x-data="{ loading: false }" @submit="loading = true"
                  class="space-y-4">
                @csrf
                @method('delete')

                <div>
                    <label for="del-password"
                           style="display:block;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:6px;">
                        Password
                    </label>
                    <input id="del-password" name="password" type="password"
                           required placeholder="Enter your password"
                           style="width:100%;padding:10px 13px;border:1.5px solid #e5e7eb;border-radius:6px;font-size:14px;color:#111827;background:#f9fafb;outline:none;">
                    @error('password', 'userDeletion')
                        <p style="font-size:12px;color:#dc2626;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:flex;justify-content:flex-end;gap:10px;">
                    <button type="button" @click="open = false"
                            style="font-size:13.5px;font-weight:500;color:#6b7280;background:#f3f4f6;border:1px solid #e5e7eb;border-radius:6px;padding:9px 18px;cursor:pointer;">
                        Cancel
                    </button>
                    <button type="submit"
                            :disabled="loading"
                            style="background:#dc2626;color:#fff;font-size:13.5px;font-weight:600;padding:9px 18px;border:none;border-radius:6px;cursor:pointer;display:inline-flex;align-items:center;gap:7px;">
                        <svg x-show="loading" style="animation:spin 0.75s linear infinite;flex-shrink:0;" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span x-text="loading ? 'Deleting...' : 'Yes, delete my account'"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</section>
