import { chromium } from 'playwright-core';
import fs from 'fs';
const base = process.env.LOCALAPPDATA + '\\ms-playwright';
const dirs = fs.readdirSync(base).filter(d => d.startsWith('chromium-'));
let exe = null;
for (const d of dirs.sort().reverse()) { const p = `${base}\\${d}\\chrome-win\\chrome.exe`; if (fs.existsSync(p)) { exe = p; break; } }
const browser = await chromium.launch({ executablePath: exe });
const page = await browser.newPage({ deviceScaleFactor: 1.5 });
await page.setViewportSize({ width: 1440, height: 1200 });
await page.goto(process.env.URL || 'http://127.0.0.1:8000', { waitUntil: 'networkidle', timeout: 60000 });
await page.waitForTimeout(1500);
if (!fs.existsSync('screenshots')) fs.mkdirSync('screenshots');
const el = page.locator('section').filter({ hasText: 'See how Nhume' });
await el.scrollIntoViewIfNeeded();
await page.waitForTimeout(800);
await el.screenshot({ path: 'screenshots/testimonials.png' });
console.log('done');
await browser.close();
