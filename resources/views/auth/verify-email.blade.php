<x-guest-layout>

    <div class="auth-head">
        <h1 class="auth-title">Verify your email</h1>
        <p class="auth-subtitle">We sent a link to your email address. Click it to activate your account.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="auth-status">A new verification link has been sent to your email address.</div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="auth-form"
          x-data="{ loading: false }"
          @submit="loading = true">
        @csrf
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
                    Resend verification email
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </span>
            </template>
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" style="margin-top:16px;text-align:center;">
        @csrf
        <button type="submit"
                style="background:none;border:none;cursor:pointer;font-family:inherit;font-size:13.5px;color:var(--muted);text-decoration:underline;">
            Sign out and use a different account
        </button>
    </form>

</x-guest-layout>
