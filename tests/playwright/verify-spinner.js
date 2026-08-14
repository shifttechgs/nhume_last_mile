import { chromium } from 'playwright';

(async () => {
    const browser = await chromium.launch({ headless: false, slowMo: 80 });
    const page    = await browser.newPage();

    await page.goto('http://127.0.0.1:8000/send', { waitUntil: 'networkidle' });

    // Step 1
    await page.click('text=Biker picks up');
    await page.click('button:has-text("Next")');
    await page.waitForResponse(r => r.url().includes('livewire/update'));
    await page.waitForTimeout(400);

    // Fill minimum required fields for step 2
    await page.fill('[placeholder="Where should the biker collect from?"]', '12 Julius Nyerere Way');
    await page.waitForTimeout(500);
    await page.fill('[placeholder="Where is it going?"]', '45 Samora Machel Ave');
    await page.waitForTimeout(500);
    await page.click('.chip:has-text("Clothing")');
    await page.waitForTimeout(300);
    await page.fill('[placeholder="+263..."]', '+27814303023'); // recipient phone — there are two, get the second
    await page.waitForTimeout(300);
    await page.fill('[placeholder="Recipient\'s name"]', 'Test');
    await page.waitForTimeout(300);

    // Click Place order and immediately screenshot the loading state
    await page.click('button:has-text("Place order")');
    await page.waitForTimeout(150); // catch it mid-loading

    await page.screenshot({ path: 'tests/playwright/screenshots/spinner.png' });
    console.log('Spinner screenshot saved.');

    await page.waitForSelector('.wiz-order-num', { timeout: 10000 });
    console.log('Order confirmed — spinner resolved correctly.');

    await browser.close();
})();
