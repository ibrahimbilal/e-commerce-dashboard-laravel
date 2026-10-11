import { chromium } from 'playwright';
import fs from 'fs';
import path from 'path';
import { execSync } from 'child_process';
import crypto from 'crypto';

const outRoot = process.env.VIS_OUT || '/opt/cursor/artifacts/screenshots/bs-regression';
const tag = process.env.VIS_TAG || 'after';
const base = process.env.VIS_BASE || 'http://127.0.0.1:8000';
const sharedDb = process.env.REGRESSION_DB || '/workspace/database/regression-shared.sqlite';

const scenarios = [
    ['products-index', '/admin/products', 'light', 'ltr'],
    ['products-index', '/admin/products', 'dark', 'ltr'],
    ['products-index', '/admin/products', 'light', 'rtl'],
    ['products-index', '/admin/products', 'dark', 'rtl'],
    ['orders-index', '/admin/orders', 'dark', 'ltr'],
    ['customers-index', '/admin/customers', 'dark', 'ltr'],
];

const localeAccounts = {
    ltr: { email: 'manager@example.com', password: 'password', language: 'en', expectDir: 'ltr' },
    rtl: { email: 'admin@example.com', password: 'password', language: 'ar', expectDir: 'rtl' },
};

function sqlExec(statement) {
    execSync(`sqlite3 ${sharedDb} ${JSON.stringify(statement)}`, { stdio: 'pipe' });
}

function prepareLocaleAccounts() {
    sqlExec("UPDATE users SET language='en' WHERE email='manager@example.com';");
    sqlExec("UPDATE users SET language='ar' WHERE email='admin@example.com';");
    sqlExec('DELETE FROM sessions;');
}

async function login(page, account) {
    await page.goto(`${base}/admin/login`, { waitUntil: 'domcontentloaded' });
    await page.fill('input[name="email"]', account.email);
    await page.fill('input[name="password"]', account.password);
    await page.click('button[type="submit"]');
    await page.waitForURL(/\/admin\//, { timeout: 30000 });
}

async function assertDocumentDir(page, expectDir, account) {
    const meta = await page.evaluate(() => ({
        dir: document.documentElement.getAttribute('dir'),
        lang: document.documentElement.getAttribute('lang'),
    }));
    if (meta.dir !== expectDir) {
        throw new Error(
            `Expected document.dir=${expectDir} for ${account.email}, got dir=${meta.dir} lang=${meta.lang}`
        );
    }
}

async function clearDataTableState(page) {
    await page.evaluate(() => {
        Object.keys(localStorage)
            .filter((key) => /datatables|DataTables/i.test(key))
            .forEach((key) => localStorage.removeItem(key));
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

async function capturePage(page, name, route, mode, dir) {
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
    return file;
}

function md5File(file) {
    return crypto.createHash('md5').update(fs.readFileSync(file)).digest('hex');
}

async function main() {
    prepareLocaleAccounts();
    const browser = await chromium.launch({ headless: true });
    const captured = [];

    for (const [name, route, mode, dir] of scenarios) {
        const account = localeAccounts[dir];
        const context = await browser.newContext({ viewport: { width: 1440, height: 900 } });
        await context.clearCookies();
        const page = await context.newPage();
        await page.evaluate(() => {
            localStorage.clear();
            sessionStorage.clear();
        });
        await login(page, account);
        await assertDocumentDir(page, account.expectDir, account);
        captured.push(await capturePage(page, name, route, mode, dir));
        await context.close();
    }

    await browser.close();

    const md5 = {};
    for (const file of captured) {
        const key = path.basename(file);
        md5[key] = md5File(file);
    }
    const ltrRtlPairs = [
        ['products-index-light-ltr', 'products-index-light-rtl'],
        ['products-index-dark-ltr', 'products-index-dark-rtl'],
    ];
    for (const [ltr, rtl] of ltrRtlPairs) {
        const ltrKey = `${ltr}-${tag}.png`;
        const rtlKey = `${rtl}-${tag}.png`;
        if (md5[ltrKey] && md5[rtlKey] && md5[ltrKey] === md5[rtlKey]) {
            throw new Error(`LTR and RTL captures are identical: ${ltrKey} vs ${rtlKey}`);
        }
    }

    console.log(JSON.stringify({ tag, base, outRoot, captured, md5 }, null, 2));
}

main().catch((e) => {
    console.error(e);
    process.exit(1);
});
