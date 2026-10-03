import { chromium } from 'playwright';

const base = process.env.APP_URL || 'http://127.0.0.1:8000';

const browser = await chromium.launch({ headless: true });
const page = await browser.newPage();
const errors = [];
page.on('pageerror', (err) => errors.push(String(err)));

await page.goto(`${base}/admin/login`, { waitUntil: 'domcontentloaded' });
await page.fill('input[name="email"]', 'admin@example.com');
await page.fill('input[name="password"]', 'password');
await page.click('button[type="submit"]');
await page.waitForURL(/\/admin\//, { timeout: 15000 });

await page.goto(`${base}/admin/theme-settings`, { waitUntil: 'networkidle' });

const before = await page.evaluate(() =>
  getComputedStyle(document.documentElement).getPropertyValue('--main-color').trim()
);

await page.locator('input[name="main_color"]').fill('#112233');
await page.locator('input[name="main_color"]').dispatchEvent('input');

const after = await page.evaluate(() =>
  getComputedStyle(document.documentElement).getPropertyValue('--main-color').trim()
);

if (after.toUpperCase() !== '#112233') {
  throw new Error(`Preview did not update --main-color (before=${before}, after=${after})`);
}

await page.click('#reset-theme-colors');
await page.locator('.swal2-confirm').click();

const reset = await page.evaluate(() =>
  getComputedStyle(document.documentElement).getPropertyValue('--main-color').trim()
);

const inputAfterReset = await page.inputValue('input[name="main_color"]');
if (reset.toUpperCase() === '#112233') {
  throw new Error('Reset did not change --main-color away from preview value');
}

await browser.close();

if (errors.length) {
  throw new Error(`Console errors: ${errors.join('; ')}`);
}

console.log(
  JSON.stringify({
    ok: true,
    before,
    afterPreview: after,
    afterReset: reset,
    mainColorInputAfterReset: inputAfterReset,
  })
);
