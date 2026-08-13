import { chromium } from 'playwright';
import { mkdirSync } from 'fs';

mkdirSync('screenshots', { recursive: true });

const browser = await chromium.launch({ headless: true });
const page = await browser.newPage();
await page.setViewportSize({ width: 1280, height: 900 });

let pass = true;
const findings = [];

function fail(msg) { pass = false; findings.push(`❌ ${msg}`); console.log(`❌ FAIL: ${msg}`); }
function warn(msg) { findings.push(`⚠️  ${msg}`); console.log(`⚠️  ${msg}`); }
function ok(msg) { console.log(`✅ ${msg}`); }

// ── Load page ──
await page.goto('http://127.0.0.1:8000/send', { waitUntil: 'networkidle' });
await page.screenshot({ path: 'screenshots/v-01-initial.png' });

// ── 1. Step 1 footer: "Next" button with arrow icon ──
const nextBtn = page.locator('.wiz-card-foot .btn-wiz-primary');
if (await nextBtn.count() !== 1) {
  fail(`Step 1 footer: expected 1 primary button, found ${await nextBtn.count()}`);
} else {
  const txt = (await nextBtn.innerText()).trim();
  if (!txt.includes('Next')) fail(`Step 1 footer button text is "${txt}", expected "Next"`);
  else ok(`Step 1 footer: "Next" button present`);

  if (await nextBtn.locator('svg').count() === 0) fail('Next button missing arrow SVG');
  else ok('Next button has arrow icon');
}

// ── 2. Sidebar disabled on step 1 ──
const sidebarBtn = page.locator('.wiz-right .btn-wiz-primary');
if (!await sidebarBtn.isDisabled()) fail('Sidebar "Place order" NOT disabled on step 1');
else ok('Sidebar "Place order" disabled on step 1');

const opacity = await sidebarBtn.evaluate(el => parseFloat(getComputedStyle(el).opacity));
if (opacity >= 1) warn(`Sidebar opacity=${opacity}, may not look greyed out`);
else ok(`Sidebar opacity=${opacity} — visually disabled`);

await page.screenshot({ path: 'screenshots/v-02-step1.png' });

// ── Advance to step 2 reliably ──
await page.locator('.pickup-card').first().click();
await page.waitForLoadState('networkidle');

const isSelected = await page.locator('.pickup-card').first().evaluate(
  el => el.classList.contains('selected')
);
console.log(`  pickup card selected state: ${isSelected}`);

// Capture spinner during Next click
const nextBtnFresh = page.locator('.wiz-card-foot .btn-wiz-primary');
let spinnerHasText = null;
const spinnerPoll = (async () => {
  for (let i = 0; i < 40; i++) {
    await page.waitForTimeout(30);
    const loading = page.locator('.wiz-card-foot [wire\\:loading]');
    if (await loading.count() > 0 && await loading.isVisible().catch(() => false)) {
      const html = await loading.innerHTML().catch(() => '');
      spinnerHasText = /checking|placing|next/i.test(html) ? html : false;
      await page.screenshot({ path: 'screenshots/v-03-next-spinner.png' });
      return;
    }
  }
})();

await nextBtnFresh.click();
await spinnerPoll;

await page.waitForFunction(() => {
  const h2 = document.querySelector('.wiz-card-head .wiz-title');
  return h2 && h2.textContent.includes('Parcel details');
}, { timeout: 8000 });

await page.waitForLoadState('networkidle');
await page.screenshot({ path: 'screenshots/v-04-step2.png' });
console.log(`  (reached step 2)`);

// ── 3. Next spinner: no text ──
if (spinnerHasText === null) warn('Spinner too fast to capture — skipping text check');
else if (spinnerHasText !== false) fail(`Next spinner contains unexpected text: ${spinnerHasText}`);
else ok('Next spinner shows icon only (no text)');

// ── 4. Step 2 footer: Back button only, no primary button ──
const step2Footer = page.locator('.wiz-card-foot');
const primaryCount = await step2Footer.locator('.btn-wiz-primary').count();
if (primaryCount > 0) fail(`Step 2 footer still has ${primaryCount} primary button(s) — expected 0`);
else ok('Step 2 footer: no primary "Place order" button');

const backCount = await step2Footer.locator('.btn-wiz-ghost').count();
if (backCount !== 1) fail(`Step 2 footer: expected 1 Back ghost button, found ${backCount}`);
else ok('Step 2 footer: "Back" ghost button present');

const footerText = await step2Footer.innerText();
const hasHint = footerText.toLowerCase().includes('panel') || footerText.toLowerCase().includes('order');
if (!hasHint) warn(`Footer hint text unclear: "${footerText.trim()}"`);
else ok(`Footer hint directs user to sidebar panel`);

// ── 5. Sidebar enabled on step 2 ──
const sidebarStep2 = page.locator('.wiz-right .btn-wiz-primary');
if (!await sidebarStep2.isEnabled()) fail('Sidebar "Place order" still disabled on step 2');
else ok('Sidebar "Place order" enabled on step 2');

const sidebarTxt = (await sidebarStep2.innerText()).trim();
if (!sidebarTxt.includes('Place order')) fail(`Sidebar button text is "${sidebarTxt}", expected "Place order"`);
else ok(`Sidebar button says "Place order"`);

await page.screenshot({ path: 'screenshots/v-05-step2-sidebar-enabled.png' });

// ── 6a. DOM sanity: confirm Livewire has hidden wire:loading span at rest ──
// Livewire 3 sets display:none (inline style) on wire:loading elements on boot.
// If the CSS class no longer conflicts, this should be 'none'.
const sidebarLoadingSpan = page.locator('.wiz-right .btn-wiz-primary [wire\\:loading]');
const sidebarDefaultSpan = page.locator('.wiz-right .btn-wiz-primary [wire\\:loading\\.remove]');
// Livewire hides wire:loading via its stylesheet rule [wire:loading][wire:loading]{display:none}
// (specificity [0,2,0]=20), not via inline style. We check computed display, not el.style.
const loadingComputedDisplay  = await sidebarLoadingSpan.evaluate(el => getComputedStyle(el).display);
const defaultComputedDisplay  = await sidebarDefaultSpan.evaluate(el => getComputedStyle(el).display);
console.log(`  wire:loading  computed display at rest: "${loadingComputedDisplay}"`);
console.log(`  wire:loading.remove computed display at rest: "${defaultComputedDisplay}"`);
if (loadingComputedDisplay !== 'none') {
  fail(`wire:loading span computed display is "${loadingComputedDisplay}" at rest — it should be hidden (double-content bug is active)`);
} else {
  ok('wire:loading span is display:none at rest — Livewire CSS rule is winning correctly');
}
if (defaultComputedDisplay === 'none') {
  warn('wire:loading.remove span is display:none at rest — it should be visible');
} else {
  ok('wire:loading.remove span is visible at rest (correct)');
}

// ── 6. Loading state isolation check ──
// Fill required fields
await page.locator('input[placeholder="Where is it going?"]').fill('123 Main St, Bulawayo');
await page.locator('input[placeholder="Recipient\'s name"]').fill('Test Recipient');
await page.locator('input[placeholder="+263..."]').fill('+263771234567');
await page.locator('.chip').first().click();
await page.waitForLoadState('networkidle');

// Capture page console to see fetch debugging
page.on('console', msg => { if (msg.text().startsWith('[fw]')) console.log(' PAGE:', msg.text()); });

// Monkey-patch window.fetch inside the browser to add a 700ms delay to Livewire responses.
await page.evaluate(() => {
  const _fetch = window.fetch;
  window.fetch = async (...args) => {
    const url = typeof args[0] === 'string' ? args[0] : args[0]?.url ?? '';
    console.log('[fw] fetch called:', url.substring(0, 80));
    const res = await _fetch(...args);
    if (url.includes('livewire') && url.includes('update')) {
      console.log('[fw] delaying livewire response 700ms');
      await new Promise(r => setTimeout(r, 700));
    }
    return res;
  };
});

// Click and observe the loading state mid-flight
await page.locator('.wiz-right .btn-wiz-primary').click();

// 350ms: Livewire has sent the request, patched fetch is holding the response
await page.waitForTimeout(350);
await page.screenshot({ path: 'screenshots/v-06-sidebar-loading.png' });

const defaultSpan    = page.locator('.wiz-right .btn-wiz-primary [wire\\:loading\\.remove]');
const loadingSpan    = page.locator('.wiz-right .btn-wiz-primary [wire\\:loading]');
const defaultVisible = await defaultSpan.isVisible().catch(() => false);
const loadingVisible = await loadingSpan.isVisible().catch(() => false);
const footerSpoiled  = await page.locator('.wiz-card-foot [wire\\:loading]').isVisible().catch(() => false);

// Wait for the patched fetch to complete and Livewire to re-render
await page.waitForLoadState('networkidle');

if (defaultVisible && loadingVisible) {
  fail('Both wire:loading and wire:loading.remove visible simultaneously — double content bug persists');
} else if (loadingVisible) {
  ok('Only wire:loading visible during request — no double content bleed');
  const html = await loadingSpan.innerHTML().catch(() => '');
  if (html.includes('Placing')) ok('Loading span shows "Placing order..." text');
  else ok('Loading span shows spinner (no unwanted text)');
} else if (defaultVisible && !loadingVisible) {
  warn('Loading span not captured — server may have responded before 300ms mark');
} else {
  warn('Neither span visible at 300ms — checking if button itself changed state');
}

if (footerSpoiled) fail('Card footer also showed loading state when sidebar was clicked');
else ok('Card footer stayed inert while sidebar processed');

// ── 7. Probe: sidebar disabled on fresh load ──
await page.goto('http://127.0.0.1:8000/send', { waitUntil: 'networkidle' });
const probeBtn = page.locator('.wiz-right .btn-wiz-primary');
if (!await probeBtn.isDisabled()) fail('🔍 Probe: sidebar clickable on fresh load — should be disabled');
else ok('🔍 Probe: sidebar correctly disabled on fresh load');

await page.screenshot({ path: 'screenshots/v-07-probe-fresh.png' });
await browser.close();

// ── Final report ──
console.log('\n── Summary ──');
if (findings.length === 0) {
  console.log('PASS — all checks passed, no warnings');
} else {
  findings.forEach(f => console.log(f));
  console.log(pass ? '\nPASS (with warnings)' : '\nFAIL');
}
process.exit(pass ? 0 : 1);
