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
    await page.fill('input[wire\\:model\\.blur="pickup_address"]', '12 Julius Nyerere Way, Harare');

    // Delivery address
    await page.fill('input[wire\\:model\\.blur="dropoff_address"]', '45 Samora Machel Ave, Harare');

    // Package category — click the "Clothing" chip
    await page.click('.chip:has-text("Clothing")');
    await page.waitForTimeout(300);

    // Sender phone
    await page.fill('input[wire\\:model\\.blur="sender_phone"]', '+27814303023');

    // Recipient
    await page.fill('input[wire\\:model\\.blur="recipient_name"]',  'Test Recipient');
    await page.fill('input[wire\\:model\\.blur="recipient_phone"]', '+27814303023');

    // Blur to trigger Livewire sync
    await page.keyboard.press('Tab');
    await page.waitForTimeout(800);

    // Screenshot before placing order
    await page.screenshot({ path: 'tests/playwright/screenshots/step2.png', fullPage: false });
    console.log('  Screenshot saved: step2.png');

    // Place order
    console.log('→ Clicking "Place order" ...');
    await page.click('button:has-text("Place order")');

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
