import { chromium } from 'playwright';

(async () => {
    const browser = await chromium.launch({ headless: false, slowMo: 120 });
    const page    = await browser.newPage();

    page.on('pageerror', err => console.error('PAGE ERROR:', err.message));

    console.log('→ Opening /send ...');
    await page.goto('http://127.0.0.1:8000/send', { waitUntil: 'networkidle' });

    // ─── STEP 1: Pickup type ──────────────────────────────────────────
    console.log('→ Step 1: selecting Biker collection ...');
    await page.click('text=Biker picks up');
    await page.waitForTimeout(400);

    await page.click('text=Next');
    await page.waitForTimeout(600);

    // ─── STEP 2: Details ──────────────────────────────────────────────
    console.log('→ Step 2: filling in details ...');

    // Pickup address (biker)
    await page.fill('[placeholder="Where should the biker collect from?"]', '12 Julius Nyerere Way, Harare');

    // Delivery address
    await page.fill('[placeholder="Where is it going?"]', '45 Samora Machel Ave, Harare');

    // Package category — click chip then force-sync to Livewire via JS
    await page.locator('.chip:has-text("Clothing")').scrollIntoViewIfNeeded();
    await page.locator('.chip:has-text("Clothing")').click();
    await page.evaluate(() => {
        const comp = window.Livewire?.first();
        if (comp) comp.set('package_category', 'clothing');
    });
    await page.waitForTimeout(500);
    await page.waitForTimeout(300);

    // Sender phone (first +263 input on the page)
    await page.locator('[placeholder="+263..."]').first().fill('+27814303023');

    // Recipient
    await page.fill('[placeholder="Recipient\'s name"]', 'Test Recipient');
    // Recipient phone (second +263 input)
    await page.locator('[placeholder="+263..."]').nth(1).fill('+27814303023');

    // Blur to trigger Livewire sync
    await page.keyboard.press('Tab');
    await page.waitForTimeout(800);

    // Screenshot before placing order
    await page.screenshot({ path: 'tests/playwright/screenshots/step2.png', fullPage: false });
    console.log('  Screenshot saved: step2.png');

    // Place order
    console.log('→ Clicking "Place order" ...');
    await page.click('button:has-text("Place order")');
    await page.waitForTimeout(3000);
    await page.screenshot({ path: 'tests/playwright/screenshots/after-place-order.png', fullPage: false });

    // ─── STEP 3: Confirmation ─────────────────────────────────────────
    console.log('→ Waiting for confirmation ...');
    await page.waitForSelector('.wiz-order-num', { timeout: 15000 });

    const orderNumber = await page.textContent('.wiz-order-num');
    console.log('✓ Order confirmed:', orderNumber.trim());

    await page.locator('.wiz-confirm').scrollIntoViewIfNeeded();
    await page.waitForTimeout(300);
    await page.screenshot({ path: 'tests/playwright/screenshots/confirmation.png', fullPage: false });
    console.log('  Screenshot saved: confirmation.png');
    console.log('✓ SMS should have been sent to 0814303023');

    await browser.close();
})();
