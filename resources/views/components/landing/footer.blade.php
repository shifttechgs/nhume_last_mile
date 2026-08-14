<style>
.site-footer { background: #081510; overflow: hidden; position: relative; }
.site-footer::before {
    content: "";
    position: absolute; top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(107,198,48,0.5), transparent);
}
.footer-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr 1fr 1fr;
    gap: 40px;
}
.footer-social {
    width: 34px; height: 34px;
    border-radius: 9px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.06);
    display: flex; align-items: center; justify-content: center;
    transition: background 0.18s, border-color 0.18s, transform 0.18s;
    text-decoration: none;
}
.footer-social svg { fill: rgba(255,255,255,0.45); transition: fill 0.18s; }
.footer-social:hover {
    background: rgba(107,198,48,0.16);
    border-color: rgba(107,198,48,0.35);
    transform: translateY(-2px);
}
.footer-social:hover svg { fill: #6bc630; }
@media (max-width: 860px) {
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 32px 24px; }
    .footer-grid > div:first-child { grid-column: 1 / -1; }
}
@media (max-width: 520px) {
    .footer-grid { grid-template-columns: 1fr; }
}
</style>

<footer class="site-footer">
    <div style="max-width:1200px;margin:0 auto;padding:60px 24px 44px;position:relative;z-index:1;">
        <div class="footer-grid" style="padding-bottom:44px;border-bottom:1px solid rgba(255,255,255,0.055);margin-bottom:32px;">

            {{-- Brand --}}
            <div>
                <div style="margin-bottom:14px;">
                    <img src="/images/nhume_logo_v2.png" alt="Nhume" style="height:46px;width:auto;filter:brightness(0) invert(1);">
                </div>
                <p style="font-family:'DM Sans',system-ui,sans-serif;font-size:13.5px;color:rgba(255,255,255,0.28);line-height:1.7;margin-bottom:22px;max-width:210px">Moving parcels with drivers already in motion.</p>
                <div style="display:flex;gap:8px;">
                    @foreach ([
                        'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z',
                        'M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z'
                    ] as $p)
                    <a href="#" class="footer-social"><svg width="15" height="15" viewBox="0 0 24 24"><path d="{{ $p }}"/></svg></a>
                    @endforeach
                </div>
            </div>

            @foreach ([
                ['Platform', ['How it works' => '/#how-it-works', 'Get Started' => route('register'), 'Browse drivers' => '/journeys', 'For transporters' => '/#transporters', 'Pricing' => '#']],
                ['Support',  ['FAQ' => '/#faq', 'Contact us' => '/contact', 'Track a parcel' => '#', 'Report an issue' => '#', 'Safety' => '#']],
                ['Company',  ['About Nhume' => '#', 'Blog' => '#', 'Careers' => '#', 'Become a partner' => '#', 'Press' => '#']],
            ] as [$heading, $links])
            <div>
                <p style="font-family:'DM Sans',system-ui,sans-serif;font-size:10.5px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.22);margin-bottom:18px;">{{ $heading }}</p>
                <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:11px;">
                    @foreach ($links as $label => $href)
                    <li><a href="{{ $href }}" style="font-family:'DM Sans',system-ui,sans-serif;font-size:13.5px;color:rgba(255,255,255,0.35);text-decoration:none;transition:color 0.15s" onmouseover="this.style.color='rgba(255,255,255,0.72)'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        {{-- Bottom bar --}}
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <p style="font-family:'DM Sans',system-ui,sans-serif;font-size:12px;color:rgba(255,255,255,0.18);margin:0">© {{ date('Y') }} Nhume Technologies. All rights reserved. &nbsp;·&nbsp; <span style="color:rgba(255,255,255,0.28)">A <a href="#" style="color:rgba(255,255,255,0.35);text-decoration:none;transition:color 0.15s" onmouseover="this.style.color='rgba(255,255,255,0.6)'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">ShiftTech</a> product</span></p>
            <div style="display:flex;gap:24px;">
                @foreach (['Terms of Service', 'Privacy Policy', 'Cookie Policy'] as $l)
                <a href="#" style="font-family:'DM Sans',system-ui,sans-serif;font-size:12px;color:rgba(255,255,255,0.16);text-decoration:none;transition:color 0.15s" onmouseover="this.style.color='rgba(255,255,255,0.45)'" onmouseout="this.style.color='rgba(255,255,255,0.16)'">{{ $l }}</a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Giant gradient watermark --}}
    <div style="overflow:hidden;line-height:0.78;pointer-events:none;user-select:none">
        <p style="font-family:'Inter','DM Sans',system-ui,sans-serif;font-size:clamp(100px,17vw,220px);font-weight:800;letter-spacing:-0.03em;margin:0;padding:0 16px;white-space:nowrap;text-align:center;background:linear-gradient(180deg,rgba(255,255,255,0.05) 0%,rgba(255,255,255,0.01) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">NHUME</p>
    </div>
</footer>
