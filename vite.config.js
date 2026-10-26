import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import { globSync } from 'glob';
import { execSync } from 'child_process';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

/*
|--------------------------------------------------------------------------
| "Bucket A" - real, compiled entries
|--------------------------------------------------------------------------
|
| These mirror webpack.mix.js's three mixAssetsDir() glob calls 1:1 - every
| non-partial (non "_"-prefixed) SCSS file under sass/base/{plugins,pages,core}
| used to be compiled to its own standalone CSS file, loaded conditionally
| per-page. Vite treats each as its own entry, hashed, resolved via the
| manifest through @vite() in Blade - same as before, just no longer copied
| to a fixed path.
|
*/
const scssPartialEntries = [
  ...globSync('resources/sass/base/plugins/**/!(_)*.scss'),
  ...globSync('resources/sass/base/pages/**/!(_)*.scss'),
  ...globSync('resources/sass/base/core/**/!(_)*.scss'),
];

const explicitEntries = [
  'resources/sass/core.scss',
  'resources/sass/overrides.scss',
  'resources/sass/color-overrides.scss',
  'resources/sass/base/custom-rtl.scss',
  'resources/sass/custom/baguetteBox.scss',
  'resources/assets/scss/style.scss',
  'resources/assets/scss/style-rtl.scss',
  'resources/assets/scss/loader.scss',
  'resources/assets/js/app.js',
  'resources/assets/js/bootstrap.js',
];

/*
|--------------------------------------------------------------------------
| "Bucket B" - static passthrough
|--------------------------------------------------------------------------
|
| Everything Mix used to just copy/concatenate verbatim (no require()/import
| anywhere in these - confirmed) rather than genuinely compile. Copied to the
| exact same public/ paths they occupy today via vite-plugin-static-copy, so
| none of these change URL and none of the Blade references to them need to
| become @vite() calls - only the mix() wrapper is dropped.
|
| A relative `dest` is resolved from build.outDir (public/build) by this
| plugin - but several Blade views reference these paths directly (e.g.
| resources/images, never wrapped in mix()) expecting the traditional flat
| public directory location, so `dest` is given as an absolute path here to
| land outside build/ entirely, at the exact same paths Mix produced.
| `rename: { stripBase: N }` strips the leading N path segments of the
| matched src before joining with dest - e.g. for a vendors/js glob, the
| leading segments are "resources", "vendors" and "js" (3 total), so
| stripBase: 3 plus a public-vendors-js dest turns
| resources/vendors/js/bootstrap/popper.js into
| public/vendors/js/bootstrap/popper.js.
|
*/
const publicDir = path.resolve(__dirname, 'public');

const staticCopyTargets = [
  { src: 'resources/vendors/js/**/*', dest: path.join(publicDir, 'vendors/js'), rename: { stripBase: 3 } },
  { src: 'resources/vendors/css/**/*', dest: path.join(publicDir, 'vendors/css'), rename: { stripBase: 3 } },
  { src: 'resources/js/scripts/**/*', dest: path.join(publicDir, 'js/scripts'), rename: { stripBase: 3 } },
  { src: 'resources/js/core/*', dest: path.join(publicDir, 'js/core'), rename: { stripBase: 3 } },
  { src: 'resources/js/custom/baguetteBox.js', dest: path.join(publicDir, 'js/custom'), rename: { stripBase: 3 } },
  { src: 'resources/assets/js/init.js', dest: path.join(publicDir, 'js'), rename: { stripBase: 3 } },
  { src: 'resources/fonts/**/*', dest: path.join(publicDir, 'fonts'), rename: { stripBase: 2 } },
  { src: 'resources/images/**/*', dest: path.join(publicDir, 'images'), rename: { stripBase: 2 } },
  { src: 'resources/data/**/*', dest: path.join(publicDir, 'data'), rename: { stripBase: 2 } },
];

export default defineConfig({
  plugins: [
    laravel({
      input: [...explicitEntries, ...scssPartialEntries],
      refresh: true,
    }),
    viteStaticCopy({
      targets: staticCopyTargets,
    }),
    {
      // vite-plugin-static-copy only writes to disk on `vite build` - in dev
      // it serves the files from the Vite dev server instead, but Blade loads
      // them via asset() from Laravel's public/. Mirror the same copies onto
      // disk when the dev server starts so `npm run dev` works standalone.
      name: 'static-copy-on-serve',
      apply: 'serve',
      buildStart() {
        const copies = [
          ['resources/vendors/js', 'vendors/js'],
          ['resources/vendors/css', 'vendors/css'],
          ['resources/js/scripts', 'js/scripts'],
          ['resources/js/core', 'js/core'],
          ['resources/js/custom/baguetteBox.js', 'js/custom/baguetteBox.js'],
          ['resources/assets/js/init.js', 'js/init.js'],
          ['resources/fonts', 'fonts'],
          ['resources/images', 'images'],
          ['resources/data', 'data'],
        ];

        for (const [src, dest] of copies) {
          const from = path.resolve(__dirname, src);
          if (fs.existsSync(from)) {
            fs.cpSync(from, path.join(publicDir, dest), { recursive: true });
          }
        }
      },
    },
    {
      // Reimplements webpack.mix.js's mix.then() rtlcss post-build hook:
      // when MIX_CONTENT_DIRECTION=rtl, run rtlcss in-place over the built
      // CSS assets (now under public/build/assets instead of public/css).
      name: 'rtlcss-post-build',
      apply: 'build',
      closeBundle() {
        if (process.env.MIX_CONTENT_DIRECTION !== 'rtl') {
          return;
        }

        const dir = path.resolve(__dirname, 'public/build/assets');

        try {
          execSync(`npx rtlcss -d -e ".css" "${dir}" "${dir}"`, { stdio: 'inherit' });
        } catch (err) {
          console.error('rtlcss post-build step failed:', err.message);
        }
      },
    },
  ],
  css: {
    preprocessorOptions: {
      scss: {
        // Carried over from webpack.mix.js's sassOptions.includePaths, so
        // `@import 'bootstrap/scss/bootstrap'` etc. keep resolving. Vite's
        // Sass integration defaults to the modern compiler API, whose
        // equivalent option is `loadPaths` (not the legacy `includePaths`).
        loadPaths: ['node_modules', 'resources/assets/'],
        quietDeps: true,
        // The Bootstrap 4 based theme partials rely on @import and global
        // Sass functions (mix, darken, map-merge, ceil...) - deprecated in
        // Dart Sass 1.80+ but still fully supported until Dart Sass 3.0.
        silenceDeprecations: ['import', 'global-builtin', 'color-functions', 'mixed-decls', 'slash-div'],
      },
    },
  },
});
