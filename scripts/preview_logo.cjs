const { chromium } = require('playwright');
const path = require('path');
const fs = require('fs');

(async () => {
  const v4   = fs.readFileSync(path.join(__dirname, '../public/images/nhume_logo_v4.png')).toString('base64');
  const dark = fs.readFileSync(path.join(__dirname, '../public/images/nhume_logo_dark_bg.png')).toString('base64');

  const browser = await chromium.launch({ headless: true });
  const page = await browser.newPage();
  await page.setViewportSize({ width: 1000, height: 500 });

  await page.setContent(`
    <html><body style="margin:0;display:flex;height:500px;font-family:sans-serif;">
      <div style="background:#062e14;width:280px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:20px;">
        <p style="color:rgba(255,255,255,0.3);font-size:10px;margin:0">DARK SIDEBAR</p>
        <img src="data:image/png;base64,${dark}" style="width:220px;height:auto;">
      </div>
      <div style="background:#fff;flex:1;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:20px;">
        <p style="color:#aaa;font-size:10px;margin:0">LANDING / FOOTER (light bg)</p>
        <img src="data:image/png;base64,${v4}" style="width:220px;height:auto;">
      </div>
      <div style="background:#f5f7f5;flex:1;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:20px;">
        <p style="color:#aaa;font-size:10px;margin:0">DASHBOARD BG</p>
        <img src="data:image/png;base64,${v4}" style="width:220px;height:auto;">
      </div>
    </body></html>
  `);

  await page.screenshot({ path: path.join(__dirname, '../screenshots/logo_preview.png') });
  console.log('Done');
  await browser.close();
})();
