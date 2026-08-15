const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch({ headless: true });
  const page = await browser.newPage();
  await page.setViewportSize({ width: 1440, height: 900 });

  // Dashboard (dark sidebar)
  await page.goto('http://localhost:8001/login');
  await page.fill('input[name="email"]', 'admin@nhume.co.zw');
  await page.fill('input[name="password"]', 'password');
  await page.click('button[type="submit"]');
  await page.waitForURL('**/dashboard', { timeout: 15000 });
  await page.screenshot({ path: 'screenshots/logo_dashboard_final.png' });
  console.log('Dashboard done');

  // Landing page (light nav)
  await page.goto('http://localhost:8001/');
  await page.waitForLoadState('domcontentloaded');
  await page.screenshot({ path: 'screenshots/logo_landing_final.png' });
  console.log('Landing done');

  await browser.close();
})();
