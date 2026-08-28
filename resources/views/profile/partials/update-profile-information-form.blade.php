<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}"
          x-data="{ loading: false }" @submit="loading = true"
          class="space-y-5">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <label for="name" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Full name</label>
            <input id="name" name="name" type="text"
                   value="{{ old('name', $user->name) }}"
                   required autofocus autocomplete="name"
                   class="block w-full px-3 py-2.5 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-md focus:outline-none focus:border-gray-700 focus:bg-white transition-colors">
            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Email address</label>
            <input id="email" name="email" type="email"
                   value="{{ old('email', $user->email) }}"
                   required autocomplete="username"
                   class="block w-full px-3 py-2.5 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-md focus:outline-none focus:border-gray-700 focus:bg-white transition-colors">
            @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-2 flex items-center gap-2">
                <p class="text-xs text-gray-500">Your email is unverified.</p>
                <button form="send-verification"
                        class="text-xs font-semibold text-green-700 hover:underline">
                    Resend verification
                </button>
            </div>
            @if (session('status') === 'verification-link-sent')
                <p class="mt-1 text-xs text-green-600 font-medium">Verification link sent.</p>
            @endif
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-4 pt-1">
            <button type="submit"
                    :disabled="loading"
                    style="background:#1C3829;color:#fff;font-size:13.5px;font-weight:600;padding:9px 20px;border:none;border-radius:6px;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:background 0.15s;">
                <svg x-show="loading" class="animate-spin" style="animation:spin 0.75s linear infinite;flex-shrink:0;" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span x-text="loading ? 'Saving...' : 'Save changes'"></span>
            </button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2500)"
               class="text-xs font-medium text-green-600">Saved.</p>
            @endif
        </div>
    </form>
</section>
