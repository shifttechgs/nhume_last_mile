<x-dashboard-layout title="Profile">
<div class="p-6 lg:p-8 max-w-[860px] mx-auto space-y-6">

    <div>
        <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">Profile</h1>
        <p class="text-sm text-gray-400 mt-0.5">Manage your account information and password.</p>
    </div>

    {{-- Profile information --}}
    <div class="d-card">
        <div class="d-card-head">
            <div class="d-h">Profile information</div>
            <p class="text-xs text-gray-400">Update your name and email address.</p>
        </div>
        <div style="padding:24px;">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- Password --}}
    <div class="d-card">
        <div class="d-card-head">
            <div class="d-h">Update password</div>
            <p class="text-xs text-gray-400">Use a long, random password to stay secure.</p>
        </div>
        <div style="padding:24px;">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Danger zone --}}
    <div class="d-card" style="border-color:#fecaca;">
        <div class="d-card-head" style="border-bottom-color:#fecaca;">
            <div class="d-h" style="color:#dc2626;">Danger zone</div>
            <p class="text-xs" style="color:#f87171;">Permanent and irreversible actions.</p>
        </div>
        <div style="padding:24px;">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>
</x-dashboard-layout>
