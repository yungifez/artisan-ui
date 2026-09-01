//courtsey livewire
let fs = require('fs')
let brotliSize = require('brotli-size')
let crypto = require('crypto')

build({
    entryPoints: [`resources/js/april.js`],
    outfile: `dist/april.js`,
    bundle: true,
    platform: 'browser',
    define: { CDN: 'true' },
})

build({
    entryPoints: [`resources/js/editor-entry.js`],
    outfile: `dist/editor.js`,
    bundle: true,
    platform: 'browser',
    define: { CDN: 'true' },
})

build({
    entryPoints: [`resources/css/april.css`],
    outfile: `dist/april.css`,
    bundle: true,
    platform: 'browser',
    define: { CDN: 'true' },
})

build({
    format: 'esm',
    entryPoints: [`resources/js/april.esm.js`],
    outfile: `dist/april.esm.js`,
    bundle: true,
    platform: 'browser',
    define: { CDN: 'true' },
})

build({
    format: 'esm',
    entryPoints: [`resources/js/editor-entry.js`],
    outfile: `dist/editor.esm.js`,
    bundle: true,
    platform: 'browser',
    define: { CDN: 'true' },
})

build({
    format: 'esm',
    entryPoints: [`resources/css/april.css`],
    outfile: `dist/april.esm.css`,
    bundle: true,
    platform: 'browser',
    define: { CDN: 'true' },
})

let jsHash = crypto.randomBytes(4).toString('hex');
let editorJsHash = crypto.randomBytes(4).toString('hex');
let cssHash = crypto.randomBytes(4).toString('hex');

fs.writeFileSync(__dirname + '/../dist/manifest.json', `
{"/april.js":"${jsHash}", "/editor.js":"${editorJsHash}", "/april.css":"${cssHash}"}
`)

// Build a minified version.
build({
    entryPoints: [`resources/js/april.js`],
    outfile: `dist/april.min.js`,
    sourcemap: 'linked',
    bundle: true,
    minify: true,
    platform: 'browser',
    define: { CDN: 'true' },
}).then(() => {
    outputSize(`dist/april.min.js`)
})

build({
    entryPoints: [`resources/js/editor-entry.js`],
    outfile: `dist/editor.min.js`,
    sourcemap: 'linked',
    bundle: true,
    minify: true,
    platform: 'browser',
    define: { CDN: 'true' },
}).then(() => {
    outputSize(`dist/editor.min.js`)
})


build({
    entryPoints: [`resources/css/april.css`],
    outfile: `dist/april.min.css`,
    sourcemap: 'linked',
    bundle: true,
    minify: true,
    platform: 'browser',
    define: { CDN: 'true' },
}).then(() => {
    outputSize(`dist/april.min.css`)
})

function build(options) {
    options.define || (options.define = {})

    // options.define['LIVEWIRE_VERSION'] = `'${getFromPackageDotJson('alpinejs', 'version')}'`
    options.define['process.env.NODE_ENV'] = process.argv.includes('--watch') ? `'production'` : `'development'`

    const esbuild = require('esbuild')
    const buildOptions = {
        // external: ['alpinejs'],
        ...options,
    }

    const result = process.argv.includes('--watch')
        ? esbuild.context(buildOptions).then((context) => context.watch())
        : esbuild.build(buildOptions)

    return result.catch(() => process.exit(1))
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
