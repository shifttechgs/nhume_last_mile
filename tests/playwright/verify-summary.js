import { chromium } from 'playwright';

(async () => {
    const browser = await chromium.launch({ headless: false, slowMo: 80 });
    const page    = await browser.newPage();

    await page.goto('http://127.0.0.1:8000/send', { waitUntil: 'networkidle' });

    // Step 1 — biker
    await page.click('text=Biker picks up');
    await page.click('button:has-text("Next")');
    await page.waitForURL('**', { waitUntil: 'networkidle' });
    await page.waitForTimeout(500);

    // Fill delivery address — wait for Livewire round-trip to complete
    const fillAndWait = async (placeholder, value) => {
        await page.fill(`[placeholder="${placeholder}"]`, value);
        await page.waitForResponse(r => r.url().includes('livewire/update'), { timeout: 5000 })
              .catch(() => {}); // ignore if no round-trip fires
        await page.waitForTimeout(200);
    };

    await fillAndWait('Where is it going?', '45 Samora Machel Ave, Harare');
    await fillAndWait('Recipient\'s name', 'Tinashe Moyo');
    await fillAndWait('+263...', '+27814303023');

    // Click clothing chip
    await page.click('.chip:has-text("Clothing")');
    await page.waitForResponse(r => r.url().includes('livewire/update'), { timeout: 3000 })
          .catch(() => {});
    await page.waitForTimeout(300);

    // Read summary values
    const rows = await page.locator('.summary-rows .srow').all();
    console.log('\n── Order Summary ──');
    for (const row of rows) {
        const key = await row.locator('.skey').textContent();
        const val = await row.locator('.sval').textContent();
        console.log(`  ${key?.trim()}: ${val?.trim()}`);
    }

    await page.screenshot({ path: 'tests/playwright/screenshots/summary-live.png' });
    console.log('\nScreenshot saved.');
    await browser.close();
})();
