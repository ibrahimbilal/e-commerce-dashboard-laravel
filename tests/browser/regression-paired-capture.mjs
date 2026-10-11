import { chromium } from 'playwright';
import fs from 'fs';
import path from 'path';
import { execSync } from 'child_process';

const outRoot = process.env.VIS_OUT || '/opt/cursor/artifacts/screenshots/bs-regression';
const tag = process.env.VIS_TAG || 'after';
const base = process.env.VIS_BASE || 'http://127.0.0.1:8000';
const sharedDb = process.env.REGRESSION_DB || '/workspace/database/regression-shared.sqlite';

const productModes = [
    ['products-index', '/admin/products', true],
];
const extraPages = [
    ['orders-index', '/admin/orders', false],
    ['customers-index', '/admin/customers', false],
];

async function login(page) {
    await page.goto(`${base}/admin/login`, { waitUntil: 'domcontentloaded' });
    await page.fill('input[name="email"]', 'admin@example.com');
    await page.fill('input[name="password"]', 'password');
    await page.click('button[type="submit"]');
    await page.waitForURL(/\/admin\//, { timeout: 30000 });
}

function setAdminLocale(locale) {
    execSync(
        `sqlite3 ${sharedDb} "UPDATE users SET language='${locale}' WHERE email='admin@example.com';"`,
        { stdio: 'pipe' }
    );
}

async function prepareContext(context) {
    await context.clearCookies();
}

async function clearDataTableState(page) {
    await page.evaluate(() => {
        try {
            Object.keys(localStorage)
                .filter((key) => /datatables|DataTables/i.test(key))
                .forEach((key) => localStorage.removeItem(key));
        } catch (e) {
            /* ignore */
        }
    });
}

async function setDark(page, on) {
    await page.evaluate((enabled) => {
        const root = document.documentElement;
        if (enabled) {
            root.classList.add('dark');
            localStorage.setItem('theme_mode', 'dark');
            document.querySelectorAll('table.table').forEach((table) => table.classList.add('table-dark'));
        } else {
            root.classList.remove('dark');
            localStorage.removeItem('theme_mode');
            document.querySelectorAll('table.table').forEach((table) => table.classList.remove('table-dark'));
        }
    }, on);
}

function shotPath(name, mode, dir) {
    return path.join(outRoot, `${name}-${mode}-${dir}-${tag}.png`);
}

async function capturePager(page, name, mode, dir) {
    const pager = page.locator('.table-holder div.dt-paging, .table-holder .dataTables_paginate').first();
    if (!(await pager.count())) {
        return null;
    }
    const box = await pager.boundingBox();
    if (!box) {
        return null;
    }
    const file = shotPath(`${name}-pager`, mode, dir);
    fs.mkdirSync(path.dirname(file), { recursive: true });
    await page.screenshot({
        path: file,
        fullPage: false,
        clip: { x: box.x, y: Math.max(0, box.y - 4), width: box.width, height: Math.min(box.height + 8, 80) },
    });
    return file;
}

async function capturePage(page, name, route, mode, dir, withPager) {
    await setDark(page, mode === 'dark');
    await page.goto(`${base}${route}`, { waitUntil: 'networkidle' });
    await setDark(page, mode === 'dark');
    await clearDataTableState(page);
    await page.reload({ waitUntil: 'networkidle' });
    await setDark(page, mode === 'dark');
    await page.waitForTimeout(400);
    const file = shotPath(name, mode, dir);
    fs.mkdirSync(path.dirname(file), { recursive: true });
    await page.screenshot({ path: file, fullPage: true });
    const files = [file];
    if (withPager) {
        const pagerFile = await capturePager(page, name, mode, dir);
        if (pagerFile) {
            files.push(pagerFile);
        }
    }
    return files;
}

async function main() {
    const browser = await chromium.launch({ headless: true });
    const captured = [];

    for (const dir of ['ltr', 'rtl']) {
        setAdminLocale(dir === 'rtl' ? 'ar' : 'en');
        const context = await browser.newContext({ viewport: { width: 1440, height: 900 } });
        await prepareContext(context);
        const page = await context.newPage();
        await login(page);
        await page.evaluate(() => {
            try {
                localStorage.clear();
                sessionStorage.clear();
            } catch (e) {
                /* ignore */
            }
        });

        for (const mode of ['light', 'dark']) {
            for (const [name, route, withPager] of productModes) {
                captured.push(...(await capturePage(page, name, route, mode, dir, withPager)));
            }
        }

        if (dir === 'ltr') {
            for (const [name, route] of extraPages) {
                captured.push(...(await capturePage(page, name, route, 'dark', 'ltr', false)));
            }
        }

        await context.close();
    }

    await browser.close();
    console.log(JSON.stringify({ tag, base, outRoot, captured }, null, 2));
}

main().catch((e) => {
    console.error(e);
    process.exit(1);
});
