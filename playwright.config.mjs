import { defineConfig } from '@playwright/test';
import { existsSync } from 'node:fs';

const systemChromium = '/usr/bin/chromium-browser';

export default defineConfig({
    testDir: './tests/browser',
    testMatch: '**/*.spec.mjs',
    fullyParallel: true,
    timeout: 10_000,
    use: {
        baseURL: 'http://127.0.0.1:4173',
        browserName: 'chromium',
        headless: true,
        launchOptions: {
            executablePath: process.env.BROWSER_EXECUTABLE || (existsSync(systemChromium) ? systemChromium : undefined),
        },
    },
    webServer: {
        command: 'node tests/browser/server.mjs',
        port: 4173,
        reuseExistingServer: true,
    },
});
