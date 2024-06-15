//courtsey livewire
let fs = require('fs')
let brotliSize = require('brotli-size')
let crypto = require('crypto')

build({
    entryPoints: [`resources/js/artisan.js`],
    outfile: `dist/artisan.js`,
    bundle: true,
    platform: 'browser',
    define: { CDN: true },
})

build({
    entryPoints: [`resources/css/artisan.css`],
    outfile: `dist/artisan.css`,
    bundle: true,
    platform: 'browser',
    define: { CDN: true },
})

build({
    format: 'esm',
    entryPoints: [`resources/js/artisan.js`],
    outfile: `dist/artisan.esm.js`,
    bundle: true,
    platform: 'node',
    define: { CDN: true },
})

build({
    format: 'esm',
    entryPoints: [`resources/css/artisan.css`],
    outfile: `dist/artisan.esm.css`,
    bundle: true,
    platform: 'node',
    define: { CDN: true },
})

let jsHash = crypto.randomBytes(4).toString('hex');
let cssHash = crypto.randomBytes(4).toString('hex');

fs.writeFileSync(__dirname+'/../dist/manifest.json', `
{"/artisan.js":"${jsHash}", "/artisan.css":"${cssHash}"}
`)

// Build a minified version.
build({
    entryPoints: [`resources/js/artisan.js`],
    outfile: `dist/artisan.min.js`,
    sourcemap: 'linked',
    bundle: true,
    minify: true,
    platform: 'browser',
    define: { CDN: true },
}).then(() => {
    outputSize(`dist/artisan.min.js`)
})


build({
    entryPoints: [`resources/css/artisan.css`],
    outfile: `dist/artisan.min.css`,
    sourcemap: 'linked',
    bundle: true,
    minify: true,
    platform: 'browser',
    define: { CDN: true },
}).then(() => {
    outputSize(`dist/artisan.min.css`)
})

function build(options) {
    options.define || (options.define = {})

    // options.define['LIVEWIRE_VERSION'] = `'${getFromPackageDotJson('alpinejs', 'version')}'`
    options.define['process.env.NODE_ENV'] = process.argv.includes('--watch') ? `'production'` : `'development'`

    return require('esbuild').build({
        watch: process.argv.includes('--watch'),
        // external: ['alpinejs'],
        ...options,
    }).catch(() => process.exit(1))
}
function outputSize(file) {
    let size = bytesToSize(brotliSize.sync(fs.readFileSync(file)))

    console.log("\x1b[32m", `Bundle size: ${size}`)
}

function bytesToSize(bytes) {
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB']
    if (bytes === 0) return 'n/a'
    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)), 10)
    if (i === 0) return `${bytes} ${sizes[i]}`
    return `${(bytes / (1024 ** i)).toFixed(1)} ${sizes[i]}`
  }
