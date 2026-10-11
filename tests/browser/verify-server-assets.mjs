import { chromium } from 'playwright';

const ports = [
    { port: 8000, label: 'after (feature tip)' },
    { port: 8001, label: 'before (26c4055^)' },
];

async function probe(base) {
    const browser = await chromium.launch({ headless: true });
    const page = await (await browser.newContext()).newPage();
    await page.goto(`${base}/admin/login`, { waitUntil: 'domcontentloaded' });
    await page.fill('input[name="email"]', 'manager@example.com');
    await page.fill('input[name="password"]', 'password');
    await page.click('button[type="submit"]');
    await page.waitForURL(/\/admin\//, { timeout: 30000 });
    const html = await page.content();
    const markers = {
        datatablesMinJs: html.includes('js/datatables.min.js') || html.includes('/datatables.min.js'),
        vendorDatatables: html.includes('vendor/datatables/js/dataTables.min.js'),
        bootstrapMin: html.includes('bootstrap.min.js') && !html.includes('bootstrap.bundle.min.js'),
        bootstrapBundle: html.includes('bootstrap.bundle.min.js'),
    };
    await page.goto(`${base}/admin/products`, { waitUntil: 'networkidle' });
    const versions = await page.evaluate(() => {
        const out = {};
        if (typeof $ !== 'undefined' && $.fn && $.fn.dataTable) {
            out.dataTable = $.fn.dataTable.version || $.fn.dataTable.ext?.version || 'unknown';
        }
        if (typeof DataTable !== 'undefined') {
            out.DataTable = DataTable.version || 'present-no-version';
        }
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            out.bootstrapTooltip = bootstrap.Tooltip.VERSION;
        }
        return out;
    });
    await browser.close();
    return { markers, versions, htmlSnippet: html.slice(0, 500) };
}

async function main() {
    const results = {};
    for (const { port, label } of ports) {
        const base = `http://127.0.0.1:${port}`;
        results[port] = { label, ...(await probe(base)) };
    }
    console.log(JSON.stringify(results, null, 2));
}

main().catch((e) => {
    console.error(e);
    process.exit(1);
});
