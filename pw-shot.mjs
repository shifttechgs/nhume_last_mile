import { chromium } from 'playwright-core';
import fs from 'fs';
const base = process.env.LOCALAPPDATA + '\\ms-playwright';
const dirs = fs.readdirSync(base).filter(d => d.startsWith('chromium-'));
let exe = null;
for (const d of dirs.sort().reverse()) {
  const p = `${base}\\${d}\\chrome-win\\chrome.exe`;
  if (fs.existsSync(p)) { exe = p; break; }
}
const browser = await chromium.launch({ executablePath: exe });
const page = await browser.newPage();
await page.setViewportSize({ width: 1440, height: 900 });
await page.goto('http://127.0.0.1:8155', { waitUntil: 'networkidle', timeout: 60000 });
await page.waitForTimeout(1000);
await page.evaluate(() => window.scrollTo({ top: 900, behavior: 'instant' }));
await page.waitForTimeout(600);
await page.screenshot({ path: 'screenshots/roles-v2.png' });
console.log('done');
await browser.close();
