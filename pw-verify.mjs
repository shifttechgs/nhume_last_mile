import { chromium } from 'playwright';

const screenshotDir = 'screenshots';

const browser = await chromium.launch();
const page = await browser.newPage();
await page.setViewportSize({ width: 1280, height: 900 });

console.log("Navigating...");
await page.goto("https://nhume-last-mile.onrender.com", { waitUntil: "networkidle", timeout: 60000 });

await page.screenshot({ path: `${screenshotDir}/01-hero.png` });
console.log("01-hero");

await page.evaluate(() => window.scrollTo(0, 600));
await page.waitForTimeout(600);
await page.screenshot({ path: `${screenshotDir}/02-stats-problem.png` });
console.log("02-stats-problem");

await page.evaluate(() => window.scrollTo(0, 1600));
await page.waitForTimeout(600);
await page.screenshot({ path: `${screenshotDir}/03-solution-steps.png` });
console.log("03-solution-steps");

await page.evaluate(() => window.scrollTo(0, 2600));
await page.waitForTimeout(600);
await page.screenshot({ path: `${screenshotDir}/04-journey-cards.png` });
console.log("04-journey-cards");

await page.evaluate(() => window.scrollTo(0, 3600));
await page.waitForTimeout(600);
await page.screenshot({ path: `${screenshotDir}/05-trust.png` });
console.log("05-trust");

await page.evaluate(() => window.scrollTo(0, 4600));
await page.waitForTimeout(600);
await page.screenshot({ path: `${screenshotDir}/06-transporters.png` });
console.log("06-transporters");

await page.evaluate(() => window.scrollTo(0, 6000));
await page.waitForTimeout(600);
await page.screenshot({ path: `${screenshotDir}/07-faq-cta.png` });
console.log("07-faq-cta");

await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
await page.waitForTimeout(600);
await page.screenshot({ path: `${screenshotDir}/08-footer.png` });
console.log("08-footer");

// Check font, CSS, layout
const diagnostics = await page.evaluate(() => ({
  font: getComputedStyle(document.body).fontFamily,
  navPosition: getComputedStyle(document.querySelector('header')).position,
  hasMarquee: !!document.querySelector('[class*="marquee"]'),
  hasBlue: !!document.querySelector('[class*="bg-primary"], [class*="bg-blue-6"]'),
  tailwindCDN: !!document.querySelector('script[src*="tailwindcss"]'),
  viteBuilt: !!document.querySelector('link[href*="/build/"]'),
  bodyBg: getComputedStyle(document.body).backgroundColor,
  h1Text: document.querySelector('h1')?.innerText?.slice(0, 60),
  pageHeight: document.body.scrollHeight,
}));
console.log("Diagnostics:", JSON.stringify(diagnostics, null, 2));

// Mobile
await page.setViewportSize({ width: 390, height: 844 });
await page.evaluate(() => window.scrollTo(0, 0));
await page.waitForTimeout(400);
await page.screenshot({ path: `${screenshotDir}/09-mobile.png` });
console.log("09-mobile");

// Click first FAQ
await page.setViewportSize({ width: 1280, height: 900 });
await page.evaluate(() => window.scrollTo(0, 4500));
await page.waitForTimeout(400);
await page.locator('#faq button').first().click();
await page.waitForTimeout(500);
await page.screenshot({ path: `${screenshotDir}/10-faq-open.png` });
console.log("10-faq-open");

await browser.close();
console.log("All screenshots captured.");
