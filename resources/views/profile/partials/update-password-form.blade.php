<section>
    <form method="post" action="{{ route('password.update') }}"
          x-data="{ loading: false }" @submit="loading = true"
          class="space-y-5">
        @csrf
        @method('put')

        {{-- Current password --}}
        <div>
            <label for="update_password_current_password"
                   class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Current password</label>
            <input id="update_password_current_password" name="current_password" type="password"
                   autocomplete="current-password"
                   class="block w-full px-3 py-2.5 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-md focus:outline-none focus:border-gray-700 focus:bg-white transition-colors">
            @error('current_password', 'updatePassword')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- New password --}}
        <div>
            <label for="update_password_password"
                   class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">New password</label>
            <input id="update_password_password" name="password" type="password"
                   autocomplete="new-password"
                   class="block w-full px-3 py-2.5 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-md focus:outline-none focus:border-gray-700 focus:bg-white transition-colors">
            @error('password', 'updatePassword')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm password --}}
        <div>
            <label for="update_password_password_confirmation"
                   class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Confirm new password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                   autocomplete="new-password"
                   class="block w-full px-3 py-2.5 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-md focus:outline-none focus:border-gray-700 focus:bg-white transition-colors">
            @error('password_confirmation', 'updatePassword')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-4 pt-1">
            <button type="submit"
                    :disabled="loading"
                    style="background:#1C3829;color:#fff;font-size:13.5px;font-weight:600;padding:9px 20px;border:none;border-radius:6px;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:background 0.15s;">
                <svg x-show="loading" style="animation:spin 0.75s linear infinite;flex-shrink:0;" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span x-text="loading ? 'Saving...' : 'Update password'"></span>
            </button>

            @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2500)"
               class="text-xs font-medium text-green-600">Password updated.</p>
            @endif
        </div>
    </form>
</section>
