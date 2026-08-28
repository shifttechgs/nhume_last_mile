<x-guest-layout>

    <div class="auth-head">
        <h1 class="auth-title">Welcome back</h1>
        <p class="auth-subtitle">Sign in to your Nhume account</p>
    </div>

    @if (session('status'))
        <div class="auth-status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form"
          x-data="{ show: false, loading: false }"
          @submit="loading = true">
        @csrf

        {{-- Email --}}
        <div class="auth-field">
            <label class="auth-label" for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   placeholder="you@example.com"
                   class="auth-input @error('email') has-error @enderror">
            @error('email') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        {{-- Password --}}
        <div class="auth-field">
            <div class="auth-label-row">
                <label class="auth-label" for="password">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-forgot">Forgot password?</a>
                @endif
            </div>
            <div class="auth-input-wrap">
                <input id="password" name="password" :type="show ? 'text' : 'password'"
                       required autocomplete="current-password"
                       placeholder="Enter your password"
                       class="auth-input @error('password') has-error @enderror">
                <button type="button" class="auth-reveal" @click="show = !show"
                        :aria-label="show ? 'Hide password' : 'Show password'">
                    <svg x-show="!show" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </button>
            </div>
            @error('password') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        {{-- Remember me --}}
        <label class="auth-check" for="remember_me">
            <input id="remember_me" type="checkbox" name="remember">
            Remember me for 30 days
        </label>

        {{-- Submit --}}
        <button type="submit" class="auth-btn" :disabled="loading">
            {{-- Loading state --}}
            <template x-if="loading">
                <span style="display:inline-flex;align-items:center;gap:8px;">
                    <svg class="auth-spinner" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Signing in...
                </span>
            </template>
            {{-- Default state --}}
            <template x-if="!loading">
                <span style="display:inline-flex;align-items:center;gap:8px;">
                    Sign in
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </span>
            </template>
        </button>
    </form>

    @if (Route::has('register'))
        <p class="auth-alt">Don't have an account? <a href="{{ route('register') }}">Create one</a></p>
    @endif

</x-guest-layout>
