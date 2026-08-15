/**
 * Removes the white background from nhume_logo_v3.png using sharp.
 * Strategy: convert to raw RGBA, walk every pixel, make near-white pixels
 * transparent with soft feathering on edge pixels to avoid harsh jagging.
 */
import sharp from 'sharp';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const srcPath  = path.join(__dirname, '../public/images/nhume_logo_v3.png');
const destPath = path.join(__dirname, '../public/images/nhume_logo_v4.png');

const img  = sharp(srcPath);
const meta = await img.metadata();
const { width, height } = meta;

// Get raw RGBA pixel buffer
const { data, info } = await img
  .ensureAlpha()
  .raw()
  .toBuffer({ resolveWithObject: true });

const buf = Buffer.from(data);

// White-removal thresholds
const WHITE_THRESHOLD = 240;   // pixels brighter than this in all channels → candidate
const FUZZ            = 25;    // distance from pure-white to start fading

for (let i = 0; i < buf.length; i += 4) {
  const r = buf[i], g = buf[i + 1], b = buf[i + 2];

  // Distance from pure white (255,255,255)
  const dist = Math.sqrt(
    (255 - r) ** 2 +
    (255 - g) ** 2 +
    (255 - b) ** 2
  );

  if (dist < FUZZ) {
    // Fully transparent for pixels very close to white
    buf[i + 3] = Math.round((dist / FUZZ) * 255 * 0.15);
  } else if (r > WHITE_THRESHOLD && g > WHITE_THRESHOLD && b > WHITE_THRESHOLD) {
    // Soft fade for near-white pixels (anti-aliasing zone)
    const excess = (r + g + b) / 3 - WHITE_THRESHOLD;
    buf[i + 3] = Math.round((1 - excess / (255 - WHITE_THRESHOLD)) * 255);
  }
  // All other pixels: keep as-is
}

await sharp(buf, {
  raw: { width: info.width, height: info.height, channels: 4 },
})
  .png({ compressionLevel: 9 })
  .toFile(destPath);

console.log(`Saved → ${destPath}`);
console.log(`Size: ${info.width}×${info.height}`);
