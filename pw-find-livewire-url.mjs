import { chromium } from 'playwright';

const browser = await chromium.launch({ headless: true });
const page = await browser.newPage();

const posts = [];
page.on('request', req => {
  if (req.method() === 'POST') posts.push(req.url());
});

await page.goto('http://127.0.0.1:8000/send', { waitUntil: 'networkidle' });
await page.locator('.pickup-card').first().click();
await page.waitForTimeout(800);
await page.locator('.wiz-card-foot .btn-wiz-primary').click();
await page.waitForTimeout(800);

console.log('POST requests seen:');
posts.forEach(u => console.log(' ', u));
await browser.close();
