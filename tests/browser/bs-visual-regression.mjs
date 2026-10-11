import { chromium } from 'playwright';
import fs from 'fs';
import path from 'path';
import { execSync } from 'child_process';
import { PNG } from 'pngjs';
import pixelmatch from 'pixelmatch';

const base = process.env.VIS_BASE || 'http://127.0.0.1:8000';
const tag = process.env.VIS_TAG || 'after';
const outRoot = process.env.VIS_OUT || '/opt/cursor/artifacts/screenshots/bs-regression';

const indexPages = [
    ['dashboard', '/admin/dashboard'],
    ['products-index', '/admin/products'],
    ['orders-index', '/admin/orders'],
    ['customers-index', '/admin/customers'],
    ['users-index', '/admin/users'],
    ['attributes-index', '/admin/attributes'],
    ['tags-index', '/admin/tags'],
    ['categories-index', '/admin/categories'],
    ['marketing-index', '/admin/marketing'],
    ['gallery-index', '/admin/gallery'],
];

async function login(page) {
    await page.goto(`${base}/admin/login`, { waitUntil: 'domcontentloaded' });
    await page.fill('input[name="email"]', 'admin@example.com');
    await page.fill('input[name="password"]', 'password');
    await page.click('button[type="submit"]');
    await page.waitForURL(/\/admin\//, { timeout: 30000 });
}

async function setDark(page, on) {
    await page.evaluate((enabled) => {
        if (enabled) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme_mode', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.removeItem('theme_mode');
        }
    }, on);
}

function sqlitePathForBase() {
    if (base.includes(':8001')) {
        return '/workspace/bs-before/database/database-before.sqlite';
    }
    return '/workspace/database/database.sqlite';
}

async function setLocale(page, locale) {
    const db = sqlitePathForBase();
    execSync(
        `sqlite3 ${db} "UPDATE users SET language='${locale}' WHERE email='admin@example.com';"`,
        { stdio: 'pipe' }
    );
    await page.context().clearCookies();
    await login(page);
    await page.waitForTimeout(300);
}

function shotPath(name, mode, dir) {
    return path.join(outRoot, `${name}-${mode}-${dir}-${tag}.png`);
}

async function screenshot(page, name, mode, dir, options = {}) {
    const file = shotPath(name, mode, dir);
    fs.mkdirSync(path.dirname(file), { recursive: true });
    await page.screenshot({ path: file, fullPage: options.fullPage !== false, ...options });
    return file;
}

async function captureSet(page, dir, mode) {
    await setDark(page, mode === 'dark');
    const captured = [];

    for (const [slug, route] of indexPages) {
        await page.goto(`${base}${route}`, { waitUntil: 'networkidle' });
        await page.waitForTimeout(400);
        captured.push(await screenshot(page, slug, mode, dir));
        if (['products-index', 'orders-index', 'customers-index'].includes(slug)) {
            const table = page.locator('.table-holder').first();
            if (await table.count()) {
                captured.push(
                    await screenshot(page, `${slug}-table-actions`, mode, dir, {
                        fullPage: false,
                        clip: await table.boundingBox(),
                    })
                );
            }
            const pager = page.locator('.table-holder div.dt-paging, .table-holder .dataTables_paginate').first();
            if (await pager.count()) {
                const box = await pager.boundingBox();
                if (box) {
                    captured.push(
                        await screenshot(page, `${slug}-pager`, mode, dir, {
                            fullPage: false,
                            clip: { ...box, height: Math.min(box.height + 8, 80), y: Math.max(0, box.y - 4) },
                        })
                    );
                }
            }
        }
    }

    await page.goto(`${base}/admin/products/create`, { waitUntil: 'networkidle' });
    captured.push(await screenshot(page, 'products-create-form', mode, dir));

    await page.goto(`${base}/admin/marketing`, { waitUntil: 'networkidle' });
    const modalBtn = page.locator('[data-bs-toggle="modal"]').first();
    if (await modalBtn.count()) {
        await modalBtn.click();
        await page.waitForTimeout(500);
        captured.push(await screenshot(page, 'marketing-modal', mode, dir));
        await page.keyboard.press('Escape');
    }

    await page.goto(`${base}/admin/dashboard`, { waitUntil: 'networkidle' });
    await page.locator('#user').click();
    await page.waitForTimeout(400);
    captured.push(await screenshot(page, 'header-dropdown', mode, dir, { fullPage: false }));

    await page.goto(`${base}/admin/users`, { waitUntil: 'networkidle' });
    captured.push(await screenshot(page, 'badges-menu', mode, dir, { fullPage: false }));

    await page.goto(`${base}/admin/users/create`, { waitUntil: 'networkidle' });
    await page.evaluate(() => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Test',
                toast: true,
                position: 'top-end',
                timer: 4000,
                showConfirmButton: false,
            });
        }
    });
    await page.waitForTimeout(600);
    captured.push(await screenshot(page, 'sweetalert-toast', mode, dir, { fullPage: false }));

    return captured;
}

function comparePair(beforePath, afterPath) {
    if (!fs.existsSync(beforePath) || !fs.existsSync(afterPath)) {
        return { beforePath, afterPath, missing: true };
    }
    const img1 = PNG.sync.read(fs.readFileSync(beforePath));
    const img2 = PNG.sync.read(fs.readFileSync(afterPath));
    const width = Math.min(img1.width, img2.width);
    const height = Math.min(img1.height, img2.height);
    const a = new PNG({ width, height });
    const b = new PNG({ width, height });
    PNG.bitblt(img1, a, 0, 0, width, height, 0, 0);
    PNG.bitblt(img2, b, 0, 0, width, height, 0, 0);
    const diff = new PNG({ width, height });
    const numDiff = pixelmatch(a.data, b.data, diff.data, width, height, { threshold: 0.1 });
    const diffPath = afterPath.replace('-after.png', '-diff.png');
    fs.writeFileSync(diffPath, PNG.sync.write(diff));
    const ratio = numDiff / (width * height);
    return { beforePath, afterPath, diffPath, numDiff, ratio, pass: ratio < 0.02 };
}

async function main() {
    const browser = await chromium.launch({ headless: true });
    const context = await browser.newContext({ viewport: { width: 1440, height: 900 } });
    const page = await context.newPage();
    await login(page);

    if (process.env.VIS_COMPARE === '1') {
        const results = [];
        for (const dir of ['ltr', 'rtl']) {
            for (const mode of ['light', 'dark']) {
                for (const [slug] of indexPages) {
                    for (const suffix of ['', '-table-actions']) {
                        const name = `${slug}${suffix}`;
                        const before = shotPath(name, mode, dir).replace('-after.png', '-before.png');
                        const after = shotPath(name, mode, dir);
                        results.push({ name, mode, dir, ...comparePair(before, after) });
                    }
                }
            }
        }
        console.log(JSON.stringify({ compare: results.filter((r) => !r.missing) }, null, 2));
        await browser.close();
        return;
    }

    for (const dir of ['ltr', 'rtl']) {
        await setLocale(page, dir === 'rtl' ? 'ar' : 'en');
        for (const mode of ['light', 'dark']) {
            await captureSet(page, dir, mode);
        }
    }

    await browser.close();
    console.log(JSON.stringify({ tag, outRoot, base }, null, 2));
}

main().catch((e) => {
    console.error(e);
    process.exit(1);
});
