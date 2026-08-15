/**
 * Creates nhume_logo_dark_bg.png — a version of the logo where:
 *  - Background is fully transparent
 *  - Dark/charcoal text pixels become white (for use on dark surfaces)
 *  - Green pixels are kept and brightened slightly
 */
import sharp from 'sharp';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const srcPath  = path.join(__dirname, '../public/images/nhume_logo_v3.png');
const destPath = path.join(__dirname, '../public/images/nhume_logo_dark_bg.png');

const { data, info } = await sharp(srcPath)
  .ensureAlpha()
  .raw()
  .toBuffer({ resolveWithObject: true });

const buf = Buffer.from(data);

for (let i = 0; i < buf.length; i += 4) {
  const r = buf[i], g = buf[i + 1], b = buf[i + 2];

  // Distance from white — used to identify background pixels
  const distFromWhite = Math.sqrt((255-r)**2 + (255-g)**2 + (255-b)**2);

  // ── Background (near-white) → fully transparent ──────────────────────
  if (distFromWhite < 30) {
    buf[i + 3] = Math.round((distFromWhite / 30) * 80); // soft edge
    continue;
  }

  // ── Determine if pixel is "green" (brand color) or "dark" (text) ─────
  const isGreenish = g > r * 1.3 && g > b * 1.3 && g > 100;

  if (isGreenish) {
    // Keep green pixels as-is — they're already visible on dark backgrounds
    buf[i]     = r;
    buf[i + 1] = g;
    buf[i + 2] = b;
    buf[i + 3] = 255;
  } else {
    // Dark/charcoal text pixels → remap to white
    // Map 0 (black) → 255 (white), preserving relative luminance
    const lum = (r * 0.299 + g * 0.587 + b * 0.114) / 255;
    // Pixels that are darker get mapped closer to white
    const whiteness = Math.round(180 + lum * 75); // range 180-255
    buf[i]     = whiteness;
    buf[i + 1] = whiteness;
    buf[i + 2] = whiteness;
    buf[i + 3] = Math.round(255 * (1 - lum * 0.3)); // slightly transparent for mid-tones
  }
}

await sharp(buf, {
  raw: { width: info.width, height: info.height, channels: 4 },
})
  .png({ compressionLevel: 9 })
  .toFile(destPath);

console.log(`Saved → ${destPath}`);
