import { chromium } from 'playwright';

(async () => {
    const browser = await chromium.launch({ headless: false, slowMo: 60 });
    const page    = await browser.newPage();

    await page.goto('http://127.0.0.1:8000/send', { waitUntil: 'networkidle' });

    // Step 1 — check Next button looks normal (no spinner)
    await page.screenshot({ path: 'tests/playwright/screenshots/btn-step1-idle.png' });
    console.log('Step 1 idle screenshot saved');

    // Click biker, then Next — capture spinner mid-request
    await page.click('text=Biker picks up');
    await page.click('button:has-text("Next")');
    await page.waitForTimeout(120); // catch mid-loading
    await page.screenshot({ path: 'tests/playwright/screenshots/btn-next-loading.png' });

    // Wait for step 2
    await page.waitForResponse(r => r.url().includes('livewire/update'));
    await page.waitForTimeout(400);

    // Step 2 — check Place order is idle (no spinner stuck)
    await page.screenshot({ path: 'tests/playwright/screenshots/btn-step2-idle.png' });
    console.log('Step 2 idle screenshot saved');

    // Check Next button has completely gone (we are on step 2 now, no Next btn)
    // The Place order button should show "Place order" text with NO spinner
    const placeOrderText = await page.locator('button.btn-wiz-primary').last().textContent();
    console.log('Place order button text:', placeOrderText?.trim().replace(/\s+/g, ' '));

    await browser.close();
})();
