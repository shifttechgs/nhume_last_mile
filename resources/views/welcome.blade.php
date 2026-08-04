<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nhume — Moving parcels with journeys already in motion</title>
    <meta name="description" content="Nhume matches your parcel with verified transporters already travelling to your destination. Faster, more flexible parcel delivery across Zimbabwe.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] },
                        colors: {
                            primary: { 50:'#eff6ff', 100:'#dbeafe', 500:'#3b82f6', 600:'#2563eb', 700:'#1d4ed8' },
                            accent:  { 50:'#fffbeb', 100:'#fef3c7', 500:'#f59e0b', 600:'#d97706' },
                        },
                        animation: { marquee: 'marquee 35s linear infinite' },
                        keyframes: { marquee: { '0%':{ transform:'translateX(0)' }, '100%':{ transform:'translateX(-50%)' } } },
                    }
                }
            }
        </script>
        <script defer src="https://unpkg.com/alpinejs@3.14.1/dist/cdn.min.js"></script>
    @endif

    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">

{{-- ═══════════════════════════════════════
     01 — NAVIGATION
═══════════════════════════════════════ --}}
<header x-data="{ mobileOpen: false }" class="fixed top-0 inset-x-0 z-50 bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <a href="/" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0v10l-8 4m0-14L4 17m8 4V11"/>
                    </svg>
                </div>
                <span class="text-xl font-bold text-gray-900">Nhume</span>
            </a>

            <nav class="hidden lg:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="#how-it-works" class="hover:text-gray-900 transition-colors">How it works</a>
                <a href="#journeys"     class="hover:text-gray-900 transition-colors">Journeys</a>
                <a href="#transporters" class="hover:text-gray-900 transition-colors">For transporters</a>
                <a href="#faq"          class="hover:text-gray-900 transition-colors">FAQ</a>
            </nav>

            <div class="hidden lg:flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">Login</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-primary-700 transition-colors">
                        Send a parcel
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @endauth
            </div>

            <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 text-gray-600 hover:text-gray-900">
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <div x-show="mobileOpen" x-cloak class="lg:hidden bg-white border-t border-gray-100 px-4 py-4 space-y-1">
        <a href="#how-it-works" @click="mobileOpen=false" class="block text-sm font-medium text-gray-700 hover:text-gray-900 py-2.5 border-b border-gray-50">How it works</a>
        <a href="#journeys"     @click="mobileOpen=false" class="block text-sm font-medium text-gray-700 hover:text-gray-900 py-2.5 border-b border-gray-50">Journeys</a>
        <a href="#transporters" @click="mobileOpen=false" class="block text-sm font-medium text-gray-700 hover:text-gray-900 py-2.5 border-b border-gray-50">For transporters</a>
        <a href="#faq"          @click="mobileOpen=false" class="block text-sm font-medium text-gray-700 hover:text-gray-900 py-2.5">FAQ</a>
        <div class="pt-4 flex flex-col gap-3">
            @auth
                <a href="{{ url('/dashboard') }}" class="block text-center bg-primary-600 text-white px-4 py-2.5 rounded-lg text-sm font-semibold">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="block text-center border border-gray-300 text-gray-700 px-4 py-2.5 rounded-lg text-sm font-medium">Login</a>
                <a href="{{ route('register') }}" class="block text-center bg-primary-600 text-white px-4 py-2.5 rounded-lg text-sm font-semibold">Send a parcel →</a>
            @endauth
        </div>
    </div>
</header>

<div class="h-16"></div>


{{-- ═══════════════════════════════════════
     02 — URGENCY STRIP
═══════════════════════════════════════ --}}
<div class="bg-primary-600 py-2.5 overflow-hidden">
    <div class="flex whitespace-nowrap">
        <div class="flex animate-marquee shrink-0">
            <span class="text-sm font-medium text-white px-4">🚌 14 journeys departing today</span>
            <span class="text-blue-300 px-2">·</span>
            <span class="text-sm font-medium text-white px-4">Harare → Bulawayo</span>
            <span class="text-blue-300 px-2">·</span>
            <span class="text-sm font-medium text-white px-4">Harare → Mutare</span>
            <span class="text-blue-300 px-2">·</span>
            <span class="text-sm font-medium text-white px-4">Harare → Gweru</span>
            <span class="text-blue-300 px-2">·</span>
            <span class="text-sm font-medium text-white px-4">Bulawayo → Victoria Falls</span>
            <span class="text-blue-300 px-2">·</span>
            <span class="text-sm font-medium text-white px-4">⏱ Next departure in 47 min</span>
            <span class="text-blue-300 px-2">·</span>
        </div>
        <div class="flex animate-marquee shrink-0" aria-hidden="true">
            <span class="text-sm font-medium text-white px-4">🚌 14 journeys departing today</span>
            <span class="text-blue-300 px-2">·</span>
            <span class="text-sm font-medium text-white px-4">Harare → Bulawayo</span>
            <span class="text-blue-300 px-2">·</span>
            <span class="text-sm font-medium text-white px-4">Harare → Mutare</span>
            <span class="text-blue-300 px-2">·</span>
            <span class="text-sm font-medium text-white px-4">Harare → Gweru</span>
            <span class="text-blue-300 px-2">·</span>
            <span class="text-sm font-medium text-white px-4">Bulawayo → Victoria Falls</span>
            <span class="text-blue-300 px-2">·</span>
            <span class="text-sm font-medium text-white px-4">⏱ Next departure in 47 min</span>
            <span class="text-blue-300 px-2">·</span>
        </div>
    </div>
</div>


{{-- ═══════════════════════════════════════
     03 — HERO
═══════════════════════════════════════ --}}
<section class="pt-16 pb-20 lg:pt-24 lg:pb-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

            <div>
                <div class="inline-flex items-center gap-2 bg-amber-50 text-amber-700 text-xs font-semibold uppercase tracking-widest px-3 py-1.5 rounded-full mb-6">
                    <span>🇿🇼</span>
                    <span>Zimbabwe's parcel network — now moving</span>
                </div>

                <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                    Your parcel<br>
                    shouldn't wait for<br>
                    <span class="text-primary-600">tomorrow's truck.</span>
                </h1>

                <p class="text-lg text-gray-500 mb-8 max-w-lg leading-relaxed">
                    Nhume matches your parcel with verified transporters already travelling to your destination — today, not tomorrow.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 mb-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition-colors shadow-sm">
                        Send a parcel
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="#how-it-works" class="inline-flex items-center justify-center gap-2 text-primary-600 font-semibold hover:underline underline-offset-2">
                        See how it works
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                </div>
                <p class="text-xs text-gray-400">No account needed to browse journeys.</p>
            </div>

            {{-- Product preview card --}}
            <div class="hidden lg:block">
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 shadow-lg">
                    <div class="flex items-center justify-between mb-5">
                        <p class="text-sm font-semibold text-gray-700">Available journeys today</p>
                        <span class="text-xs bg-green-100 text-green-700 font-medium px-2.5 py-1 rounded-full">● Live</span>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-100 p-4 mb-3 shadow-sm">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Harare → Bulawayo</p>
                                <p class="text-xs text-gray-400 mt-0.5">Departing 14:00 · Today</p>
                            </div>
                            <span class="text-xs bg-blue-50 text-blue-700 font-medium px-2 py-0.5 rounded-full shrink-0 border border-blue-100">🔵 Reviewed</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 text-xs font-bold">TM</div>
                                <div>
                                    <p class="text-xs font-medium text-gray-700">Tendai M.</p>
                                    <p class="text-xs text-gray-400">Toyota Quantum</p>
                                </div>
                            </div>
                            <p class="text-sm font-bold text-gray-900">from $3</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-100 p-4 mb-5 shadow-sm">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Harare → Mutare</p>
                                <p class="text-xs text-gray-400 mt-0.5">Departing 15:30 · Today</p>
                            </div>
                            <span class="text-xs bg-emerald-50 text-emerald-700 font-medium px-2 py-0.5 rounded-full shrink-0 border border-emerald-100">✅ Verified</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 text-xs font-bold">CN</div>
                                <div>
                                    <p class="text-xs font-medium text-gray-700">Chipo N.</p>
                                    <p class="text-xs text-gray-400">Intercity shuttle</p>
                                </div>
                            </div>
                            <p class="text-sm font-bold text-gray-900">from $4</p>
                        </div>
                    </div>

                    <a href="{{ route('register') }}" class="block w-full text-center text-sm font-semibold text-primary-600 py-2.5 border border-primary-200 rounded-lg bg-primary-50 hover:bg-primary-100 transition-colors">
                        Browse all 14 journeys today →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════
     04 — STATS BAR
═══════════════════════════════════════ --}}
<section class="py-12 bg-white border-t border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div>
                <p class="text-4xl font-extrabold text-primary-600">500+</p>
                <p class="text-sm text-gray-500 mt-1">Parcels moved</p>
            </div>
            <div>
                <p class="text-4xl font-extrabold text-primary-600">20</p>
                <p class="text-sm text-gray-500 mt-1">Verified transporters</p>
            </div>
            <div>
                <p class="text-4xl font-extrabold text-primary-600">4</p>
                <p class="text-sm text-gray-500 mt-1">Active routes</p>
            </div>
            <div>
                <p class="text-4xl font-extrabold text-primary-600">&lt;6 hrs</p>
                <p class="text-sm text-gray-500 mt-1">Avg. Harare–Bulawayo</p>
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════
     05 — PROBLEM
═══════════════════════════════════════ --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Sound familiar?</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
                <div class="text-3xl mb-4">🕐</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">"The truck leaves tonight."</h3>
                <p class="text-sm text-gray-500 leading-relaxed">You need it there today. Three buses have already left for Bulawayo. The space was there — just not connected to you.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
                <div class="text-3xl mb-4">📦</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">"Delivery will be tomorrow."</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Your parcel sits in a depot overnight. The recipient waits. The opportunity passes. You still pay the same price.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
                <div class="text-3xl mb-4">💸</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">"That'll be $12 for 2-day delivery."</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Courier pricing built for bulk volumes — not for a single parcel between two people on the same corridor.</p>
            </div>
        </div>

        <div class="text-center">
            <p class="text-xl font-semibold text-gray-700">
                The problem isn't a lack of transport.<br>
                <span class="text-primary-600">It's that transport and parcels aren't connected.</span>
            </p>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════
     06 — SOLUTION
═══════════════════════════════════════ --}}
<section class="py-20 bg-white text-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-semibold uppercase tracking-widest text-primary-600 mb-4">The Nhume difference</p>
        <h2 class="text-4xl font-extrabold text-gray-900 mb-6">We connect them.</h2>
        <p class="text-lg text-gray-500 leading-relaxed mb-12">
            Every day, hundreds of vehicles travel between Zimbabwe's cities with empty cargo space.<br>
            Nhume lets that space carry your parcel — on a journey already in motion.
        </p>

        {{-- Route visual --}}
        <div class="flex items-center justify-center gap-0 max-w-sm mx-auto">
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 rounded-full bg-primary-600 flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-xs font-semibold text-gray-700 mt-2">Harare</p>
            </div>
            <div class="flex-1 flex items-center relative mx-3">
                <div class="h-0.5 bg-gray-200 w-full"></div>
                <div class="absolute left-1/2 -translate-x-1/2 w-9 h-9 rounded-full bg-amber-500 flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                </div>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 rounded-full bg-primary-600 flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-xs font-semibold text-gray-700 mt-2">Bulawayo</p>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-4">Your parcel rides on a journey already in motion</p>
    </div>
</section>


{{-- ═══════════════════════════════════════
     07 — HOW IT WORKS
═══════════════════════════════════════ --}}
<section id="how-it-works" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-xs font-semibold uppercase tracking-widest text-primary-600 mb-3">Simple process</p>
            <h2 class="text-3xl font-bold text-gray-900">Send a parcel in 3 steps</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-10">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-600 text-white font-extrabold text-2xl mb-6 shadow-sm">1</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Post your parcel</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Tell us what, where from, and where to. Takes 60 seconds. No account needed to start browsing.</p>
            </div>
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-600 text-white font-extrabold text-2xl mb-6 shadow-sm">2</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Choose a journey</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Browse verified transporters already heading your way. See trust rating, departure time, and price. Pick the one that fits.</p>
            </div>
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-600 text-white font-extrabold text-2xl mb-6 shadow-sm">3</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Done. Track it live.</h3>
                <p class="text-sm text-gray-500 leading-relaxed">The transporter picks up your parcel and delivers it. You track every step. The recipient is notified on arrival.</p>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-primary-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-700 transition-colors shadow-sm">
                Post a parcel now — it's free
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════
     08 — FEATURED JOURNEYS
═══════════════════════════════════════ --}}
<section id="journeys" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-primary-600 mb-2">Book today</p>
                <h2 class="text-3xl font-bold text-gray-900">Journeys leaving soon</h2>
                <p class="text-gray-500 mt-2 text-sm">These transporters are already heading there — book the space.</p>
            </div>
            <a href="{{ route('register') }}" class="shrink-0 text-sm font-semibold text-primary-600 hover:underline underline-offset-2">Browse all journeys →</a>
        </div>

        <div class="grid md:grid-cols-3 gap-6">

            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-lg font-semibold text-gray-900">Harare → Bulawayo</p>
                        <p class="text-sm text-gray-400 mt-0.5">Departing 14:00 · Today</p>
                    </div>
                    <span class="text-xs bg-green-50 text-green-700 font-medium px-2.5 py-1 rounded-full border border-green-100">TODAY</span>
                </div>
                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 text-sm font-bold shrink-0">TM</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">Tendai Moyo</p>
                        <p class="text-xs text-gray-400">Toyota Quantum</p>
                    </div>
                    <span class="text-xs bg-blue-50 text-blue-700 font-medium px-2 py-0.5 rounded-full border border-blue-100 shrink-0">🔵 Reviewed</span>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <div><p class="text-xs text-gray-400">Space for</p><p class="text-sm font-semibold text-gray-700">4 parcels</p></div>
                    <div class="text-right"><p class="text-xs text-gray-400">From</p><p class="text-lg font-bold text-gray-900">$3 <span class="text-xs font-normal text-gray-400">/ parcel</span></p></div>
                </div>
                <a href="{{ route('register') }}" class="block w-full text-center text-sm font-semibold text-primary-600 py-2 border border-primary-200 rounded-lg hover:bg-primary-50 transition-colors">Book this space →</a>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-lg font-semibold text-gray-900">Harare → Mutare</p>
                        <p class="text-sm text-gray-400 mt-0.5">Departing 15:30 · Today</p>
                    </div>
                    <span class="text-xs bg-green-50 text-green-700 font-medium px-2.5 py-1 rounded-full border border-green-100">TODAY</span>
                </div>
                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 text-sm font-bold shrink-0">CN</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">Chipo Ndlovu</p>
                        <p class="text-xs text-gray-400">Intercity shuttle</p>
                    </div>
                    <span class="text-xs bg-emerald-50 text-emerald-700 font-medium px-2 py-0.5 rounded-full border border-emerald-100 shrink-0">✅ Verified</span>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <div><p class="text-xs text-gray-400">Space for</p><p class="text-sm font-semibold text-gray-700">2 parcels</p></div>
                    <div class="text-right"><p class="text-xs text-gray-400">From</p><p class="text-lg font-bold text-gray-900">$4 <span class="text-xs font-normal text-gray-400">/ parcel</span></p></div>
                </div>
                <a href="{{ route('register') }}" class="block w-full text-center text-sm font-semibold text-primary-600 py-2 border border-primary-200 rounded-lg hover:bg-primary-50 transition-colors">Book this space →</a>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-lg font-semibold text-gray-900">Harare → Gweru</p>
                        <p class="text-sm text-gray-400 mt-0.5">Departing 16:00 · Today</p>
                    </div>
                    <span class="text-xs bg-green-50 text-green-700 font-medium px-2.5 py-1 rounded-full border border-green-100">TODAY</span>
                </div>
                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-sm font-bold shrink-0">SM</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">Sifiso Mhlanga</p>
                        <p class="text-xs text-gray-400">Cargo van · 3-ton</p>
                    </div>
                    <span class="text-xs bg-blue-50 text-blue-700 font-medium px-2 py-0.5 rounded-full border border-blue-100 shrink-0">🔵 Reviewed</span>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <div><p class="text-xs text-gray-400">Space for</p><p class="text-sm font-semibold text-gray-700">6 parcels</p></div>
                    <div class="text-right"><p class="text-xs text-gray-400">From</p><p class="text-lg font-bold text-gray-900">$2.50 <span class="text-xs font-normal text-gray-400">/ parcel</span></p></div>
                </div>
                <a href="{{ route('register') }}" class="block w-full text-center text-sm font-semibold text-primary-600 py-2 border border-primary-200 rounded-lg hover:bg-primary-50 transition-colors">Book this space →</a>
            </div>

        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════
     09 — TRUST
═══════════════════════════════════════ --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-primary-600 mb-3">Safety first</p>
            <h2 class="text-3xl font-bold text-gray-900 max-w-2xl mx-auto">
                Every transporter is reviewed before they carry your parcel.
            </h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-2xl p-6 border border-gray-200">
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <span class="inline-flex items-center text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full mb-3">○ Unverified</span>
                <p class="text-sm text-gray-500 leading-relaxed">Registered but not yet reviewed. Not eligible to carry parcels until reviewed.</p>
            </div>

            <div class="bg-blue-50 rounded-2xl p-6 border-2 border-blue-200 relative">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 whitespace-nowrap">
                    <span class="bg-primary-600 text-white text-xs font-semibold px-3 py-1 rounded-full">Minimum bar</span>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mb-4 mt-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <span class="inline-flex items-center text-xs font-medium text-blue-700 bg-blue-100 px-2.5 py-1 rounded-full mb-3">🔵 Nhume Reviewed</span>
                <p class="text-sm text-blue-800 leading-relaxed font-medium">Our team has spoken to this transporter personally before they go live.</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-200">
                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                </div>
                <span class="inline-flex items-center text-xs font-medium text-amber-700 bg-amber-100 px-2.5 py-1 rounded-full mb-3">🟡 ID Submitted</span>
                <p class="text-sm text-gray-500 leading-relaxed">Documents uploaded and under active review by the Nhume team.</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-200">
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" clip-rule="evenodd"/></svg>
                </div>
                <span class="inline-flex items-center text-xs font-medium text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full mb-3">✅ Verified</span>
                <p class="text-sm text-gray-500 leading-relaxed">Fully background-checked. Identity, vehicle, and references confirmed.</p>
            </div>
        </div>

        <p class="text-sm text-gray-400 text-center">
            We only list transporters who are at minimum <strong class="text-gray-600">Nhume Reviewed</strong>. No anonymous drivers. No unverified strangers.
        </p>
    </div>
</section>


{{-- ═══════════════════════════════════════
     10 — FOR TRANSPORTERS
═══════════════════════════════════════ --}}
<section id="transporters" class="py-20 bg-primary-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">

            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-blue-200 mb-4">For transport operators</p>
                <h2 class="text-4xl font-extrabold text-white mb-6 leading-tight">
                    You're already making the trip.<br>
                    <span class="text-blue-200">Get paid for the space you're not using.</span>
                </h2>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-200 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <p class="text-blue-100 text-sm leading-relaxed">Zero deadhead kilometres — earn on every journey you're already taking</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-200 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <p class="text-blue-100 text-sm leading-relaxed">You set your own price and availability — full control, no fixed commitment</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-200 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <p class="text-blue-100 text-sm leading-relaxed">Nhume handles the matching — you focus on driving, we find the parcels</p>
                    </li>
                </ul>
                <div>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white text-primary-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors shadow-sm">
                        Register as a transporter
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <p class="text-xs text-blue-200 mt-3">Free to join. Commission only when you earn.</p>
                </div>
            </div>

            <div class="hidden lg:block">
                <div class="bg-white bg-opacity-10 rounded-2xl p-8 border border-white border-opacity-20">
                    <p class="text-sm font-semibold text-white mb-6">Example: Harare → Bulawayo run</p>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-white border-opacity-10">
                            <div>
                                <p class="text-sm font-medium text-white">3 parcels booked</p>
                                <p class="text-xs text-blue-200">Avg. $4 per parcel</p>
                            </div>
                            <p class="text-lg font-bold text-white">$12</p>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-white border-opacity-10">
                            <div>
                                <p class="text-sm font-medium text-white">Nhume commission</p>
                                <p class="text-xs text-blue-200">15%</p>
                            </div>
                            <p class="text-sm text-blue-200">−$1.80</p>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <p class="text-base font-semibold text-white">Your earning</p>
                            <p class="text-2xl font-extrabold text-white">$10.20</p>
                        </div>
                    </div>
                    <p class="text-xs text-blue-200 mt-6">On a trip you were already making. Your fuel cost doesn't change.</p>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════
     11 — ROUTES
═══════════════════════════════════════ --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-xs font-semibold uppercase tracking-widest text-primary-600 mb-3">Coverage</p>
        <h2 class="text-3xl font-bold text-gray-900 mb-10">Active routes</h2>
        <div class="flex flex-wrap justify-center gap-3 mb-8">
            <span class="bg-white border border-gray-200 rounded-full px-5 py-2.5 text-sm font-medium text-gray-700 shadow-sm">🚌 Harare → Bulawayo</span>
            <span class="bg-white border border-gray-200 rounded-full px-5 py-2.5 text-sm font-medium text-gray-700 shadow-sm">🚌 Harare → Mutare</span>
            <span class="bg-white border border-gray-200 rounded-full px-5 py-2.5 text-sm font-medium text-gray-700 shadow-sm">🚌 Harare → Gweru</span>
            <span class="bg-white border border-gray-200 rounded-full px-5 py-2.5 text-sm font-medium text-gray-700 shadow-sm">🚌 Bulawayo → Victoria Falls</span>
            <span class="bg-primary-50 border border-primary-200 rounded-full px-5 py-2.5 text-sm font-medium text-primary-600">+ More coming</span>
        </div>
        <p class="text-sm text-gray-500">
            Don't see your route?
            <a href="{{ route('register') }}" class="text-primary-600 font-semibold hover:underline underline-offset-2 ml-1">Request a route →</a>
        </p>
    </div>
</section>


{{-- ═══════════════════════════════════════
     12 — TESTIMONIALS
═══════════════════════════════════════ --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-primary-600 mb-3">Real people, real journeys</p>
            <h2 class="text-3xl font-bold text-gray-900">What people are saying</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 border-l-4 border-primary-600 shadow-sm">
                <p class="text-gray-700 text-sm leading-relaxed mb-5 italic">"Sent documents from Harare to Bulawayo. They arrived in under 5 hours. The transporter picked them up from my office — I didn't go anywhere."</p>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 text-sm font-bold">RT</div>
                    <div><p class="text-sm font-semibold text-gray-800">Ruvimbo T.</p><p class="text-xs text-gray-400">Harare · Documents</p></div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border-l-4 border-amber-500 shadow-sm">
                <p class="text-gray-700 text-sm leading-relaxed mb-5 italic">"I drive Harare to Byo three times a week. I've started earning an extra $30–40 per trip from parcels. The app is straightforward."</p>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 text-sm font-bold">BM</div>
                    <div><p class="text-sm font-semibold text-gray-800">Blessing M.</p><p class="text-xs text-gray-400">Bulawayo · Transporter</p></div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border-l-4 border-emerald-500 shadow-sm">
                <p class="text-gray-700 text-sm leading-relaxed mb-5 italic">"We send spare parts between branches weekly. Nhume is consistently faster than the courier depot schedule and the pricing is fair."</p>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 text-sm font-bold">TS</div>
                    <div><p class="text-sm font-semibold text-gray-800">Tariro S.</p><p class="text-xs text-gray-400">Harare · Spare parts SME</p></div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════
     13 — FAQ
═══════════════════════════════════════ --}}
<section id="faq" class="py-20 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-primary-600 mb-3">Got questions?</p>
            <h2 class="text-3xl font-bold text-gray-900">Common questions</h2>
        </div>

        <div x-data="{ open: null }" class="space-y-3">
            @php
            $faqs = [
                ['q' => 'Is my parcel insured?',
                 'a' => 'Every booking on Nhume includes basic parcel cover. For high-value items, you can declare the value and add extended cover at checkout. We always show you your cover details before you confirm.'],
                ['q' => "What if the transporter doesn't show up?",
                 'a' => 'You only pay after the transporter confirms pickup. If they cancel, you receive a full refund instantly — no questions asked. We also maintain backup transporter options on all popular routes.'],
                ['q' => 'How are transporters verified?',
                 'a' => 'All transporters are at minimum "Nhume Reviewed" — our team speaks personally to every transporter before they go live. Higher tiers require ID submission and background checks. You can see each transporter\'s trust tier on their profile.'],
                ['q' => 'What can I send?',
                 'a' => 'Documents, clothing, electronics, food items, and small household goods. No hazardous materials, no live animals, and nothing prohibited under Zimbabwean law. Maximum dimensions and weight are shown at checkout.'],
                ['q' => 'How does the transporter pick up my parcel?',
                 'a' => 'Once you book, you and the transporter agree on a pickup point — usually a central, public location in your city. Details are confirmed via the platform. You\'ll never hand over a parcel without a confirmed booking reference.'],
                ['q' => 'Do I need an account to book?',
                 'a' => 'You can browse all available journeys without an account. You\'ll only need to create a free account at the moment of booking — it takes under 60 seconds: name, phone number, and email.'],
            ];
            @endphp

            @foreach($faqs as $i => $faq)
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button
                    @click="open = open === {{ $i }} ? null : {{ $i }}"
                    class="w-full flex items-center justify-between px-6 py-4 text-left bg-white hover:bg-gray-50 transition-colors"
                >
                    <span class="text-sm font-semibold text-gray-900 pr-4">{{ $faq['q'] }}</span>
                    <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === {{ $i }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open === {{ $i }}" x-cloak class="px-6 pb-5 bg-white">
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════
     14 — FINAL CTA
═══════════════════════════════════════ --}}
<section class="py-20 bg-primary-600 text-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-extrabold text-white mb-4">Your parcel could be there today.</h2>
        <p class="text-lg text-blue-100 mb-10">Browse journeys leaving now — no account required.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 bg-white text-primary-600 px-8 py-3.5 rounded-lg font-semibold hover:bg-blue-50 transition-colors shadow-sm text-sm">
                Browse journeys
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 border-2 border-white text-white px-8 py-3.5 rounded-lg font-semibold hover:bg-white hover:bg-opacity-10 transition-colors text-sm">
                Post a parcel
            </a>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════
     15 — FOOTER
═══════════════════════════════════════ --}}
<footer class="bg-gray-900 text-gray-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-gray-800">

            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0v10l-8 4m0-14L4 17m8 4V11"/></svg>
                    </div>
                    <span class="text-white font-bold text-lg">Nhume</span>
                </div>
                <p class="text-sm leading-relaxed text-gray-400 mb-5">Moving parcels with journeys already in motion.</p>
                <div class="flex gap-4">
                    <a href="#" aria-label="Facebook" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" aria-label="Twitter" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-white text-sm font-semibold mb-4">Platform</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="#how-it-works" class="hover:text-white transition-colors">How it works</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Send a parcel</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Browse journeys</a></li>
                    <li><a href="#transporters" class="hover:text-white transition-colors">For transporters</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white text-sm font-semibold mb-4">Support</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="#faq" class="hover:text-white transition-colors">FAQ</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Contact us</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Report an issue</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Track a parcel</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white text-sm font-semibold mb-4">Company</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-white transition-colors">About Nhume</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Safety policy</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Become a partner</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                </ul>
            </div>

        </div>

        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
            <p>© {{ date('Y') }} Nhume. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
