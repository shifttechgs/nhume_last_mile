<x-guest-layout>

    <div class="auth-head">
        <h1 class="auth-title">Forgot your password?</h1>
        <p class="auth-subtitle">Enter your email and we'll send a reset link.</p>
    </div>

    @if (session('status'))
        <div class="auth-status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="auth-form"
          x-data="{ loading: false }"
          @submit="loading = true">
        @csrf

        <div class="auth-field">
            <label class="auth-label" for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   placeholder="you@example.com"
                   class="auth-input @error('email') has-error @enderror">
            @error('email') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="auth-btn" :disabled="loading">
            <template x-if="loading">
                <span style="display:inline-flex;align-items:center;gap:8px;">
                    <svg class="auth-spinner" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Sending...
                </span>
            </template>
            <template x-if="!loading">
                <span style="display:inline-flex;align-items:center;gap:8px;">
                    Send reset link
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </span>
            </template>
        </button>
    </form>

    <p class="auth-alt"><a href="{{ route('login') }}">← Back to sign in</a></p>

</x-guest-layout>
