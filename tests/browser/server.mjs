import { createReadStream, existsSync, statSync } from 'node:fs';
import { createServer } from 'node:http';
import { extname, join, normalize, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = resolve(fileURLToPath(new URL('../..', import.meta.url)));
const port = Number(process.env.PORT || 4173);
const contentTypes = {
    '.css': 'text/css; charset=utf-8',
    '.html': 'text/html; charset=utf-8',
    '.js': 'text/javascript; charset=utf-8',
    '.json': 'application/json; charset=utf-8',
    '.map': 'application/json; charset=utf-8',
};

createServer((request, response) => {
    const requested = decodeURIComponent((request.url || '/').split('?')[0]);
    const path = requested === '/'
        ? join(root, 'tests/browser/fixture.html')
        : normalize(join(root, requested.startsWith('/node_modules/') || requested.startsWith('/dist/')
            ? requested
            : 'tests/browser/' + requested));
    const allowed = path === root || path.startsWith(root + '/');

    if (!allowed || !existsSync(path) || !statSync(path).isFile()) {
        response.writeHead(404);
        response.end('Not found');
        return;
    }

    response.writeHead(200, {
        'Content-Type': contentTypes[extname(path)] || 'application/octet-stream',
    });
    createReadStream(path).pipe(response);
}).listen(port, '127.0.0.1');
