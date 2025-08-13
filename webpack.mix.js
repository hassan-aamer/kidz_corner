// const mix = require('laravel-mix');
// const purgeCss = require('@fullhuman/postcss-purgecss');

// mix.postCss('resources/css/app.css', 'public/css', [
//     purgeCss({
//         content: [
//             './resources/views/**/*.blade.php',
//             './resources/js/**/*.js',
//         ],
//         safelist: ['show', 'active', /^btn-/, /^text-/, /^bg-/],
//         defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
//     })
// ]);

// mix.js('resources/js/app.js', 'public/js').version();



const mix = require('laravel-mix');
const purgeCss = require('@fullhuman/postcss-purgecss');

mix.styles([
    'resources/css/main.css',
    'resources/css/custom.css',
], 'public/css/app.css');

mix.postCss('public/css/app.css', 'public/css', [
    purgeCss({
        content: [
            './resources/views/**/*.blade.php',
            './resources/js/**/*.js',
        ],
        safelist: [
            'show',
            'active',
            /btn-/,
            /text-/,
            /bg-/,
        ],
        defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || [],
    })
]);

mix.js('resources/js/app.js', 'public/js').version();
