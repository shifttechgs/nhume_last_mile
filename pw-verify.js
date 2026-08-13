const { chromium } = require('playwright');
const path = require('path');

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  await page.setViewportSize({ width: 1280, height: 900 });

  console.log("Navigating to site...");
  await page.goto("https://nhume-last-mile.onrender.com", { waitUntil: "networkidle", timeout: 60000 });

  // Full page screenshot
  await page.screenshot({ path: "screenshots/01-full-above-fold.png", fullPage: false });
  console.log("Screenshot 1: above fold");

  // Scroll to check each section
  await page.evaluate(() => window.scrollTo(0, 600));
  await page.waitForTimeout(500);
  await page.screenshot({ path: "screenshots/02-stats-problem.png", fullPage: false });
  console.log("Screenshot 2: stats + problem");

  await page.evaluate(() => window.scrollTo(0, 1600));
  await page.waitForTimeout(500);
  await page.screenshot({ path: "screenshots/03-how-it-works.png", fullPage: false });
  console.log("Screenshot 3: how it works");

  await page.evaluate(() => window.scrollTo(0, 2600));
  await page.waitForTimeout(500);
  await page.screenshot({ path: "screenshots/04-journey-cards.png", fullPage: false });
  console.log("Screenshot 4: journey cards");

  await page.evaluate(() => window.scrollTo(0, 3600));
  await page.waitForTimeout(500);
  await page.screenshot({ path: "screenshots/05-trust-transporters.png", fullPage: false });
  console.log("Screenshot 5: trust + transporters");

  await page.evaluate(() => window.scrollTo(0, 5000));
  await page.waitForTimeout(500);
  await page.screenshot({ path: "screenshots/06-faq-cta-footer.png", fullPage: false });
  console.log("Screenshot 6: FAQ + CTA + footer");

  // Check for CSS loading
  const hasTailwind = await page.evaluate(() => {
    const el = document.querySelector('.bg-primary-600, [class*="bg-blue"], [class*="text-primary"]');
    return !!el;
  });
  console.log("Has brand blue elements:", hasTailwind);

  // Check nav is sticky
  const navPos = await page.evaluate(() => {
    const nav = document.querySelector('header');
    return nav ? getComputedStyle(nav).position : 'not found';
  });
  console.log("Nav position:", navPos);

  // Check Inter font loaded
  const font = await page.evaluate(() => getComputedStyle(document.body).fontFamily);
  console.log("Body font:", font);

  // Check marquee animation
  const hasMarquee = await page.evaluate(() => {
    const el = document.querySelector('.animate-marquee');
    return !!el;
  });
  console.log("Has marquee:", hasMarquee);

  // Mobile view
  await page.setViewportSize({ width: 390, height: 844 });
  await page.evaluate(() => window.scrollTo(0, 0));
  await page.waitForTimeout(400);
  await page.screenshot({ path: "screenshots/07-mobile-hero.png", fullPage: false });
  console.log("Screenshot 7: mobile hero");

  // Click hamburger
  const hamburger = page.locator('button[\\@click], header button').last();
  await hamburger.click().catch(() => {});
  await page.waitForTimeout(400);
  await page.screenshot({ path: "screenshots/08-mobile-menu.png", fullPage: false });
  console.log("Screenshot 8: mobile menu");

  // Open first FAQ item
  await page.setViewportSize({ width: 1280, height: 900 });
  await page.evaluate(() => window.scrollTo(0, 4200));
  await page.waitForTimeout(400);
  const faqBtn = page.locator('#faq button').first();
  await faqBtn.click().catch(() => {});
  await page.waitForTimeout(400);
  await page.screenshot({ path: "screenshots/09-faq-open.png", fullPage: false });
  console.log("Screenshot 9: FAQ open");

  await browser.close();
  console.log("Done.");
})();
