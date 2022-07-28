const mix = require('laravel-mix');

const crypto = require("crypto");
const crypto_orig_createHash = crypto.createHash;
crypto.createHash = algorithm => crypto_orig_createHash(algorithm == "md4" ? "sha256" : algorithm);

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/am.scss', 'public/css')
    .sass('resources/sass/theme_am/blog.scss', 'public/css/am')
    .sass('resources/sass/theme_am/unit.scss', 'public/css/am')
    .sass('resources/sass/theme_am/profile.scss', 'public/css/am')
    .sass('resources/sass/theme_am/missing_lessons.scss', 'public/css/am')
    .sass('resources/sass/theme_am/fastings_list.scss', 'public/css/am')
    .sass('resources/sass/theme_am/diary.scss', 'public/css/am')
    .sass('resources/sass/theme_am/diary_record.scss', 'public/css/am')
    .sass('resources/sass/theme_am/conversation.scss', 'public/css/am')
    .sass('resources/sass/theme_am/request.scss', 'public/css/am')
    .sass('resources/sass/theme_am/practices.scss', 'public/css/am')
    .sass('resources/sass/theme_am/docs.scss', 'public/css/am')
    .sass('resources/sass/theme_am/dharmacakra.scss', 'public/css/am')
    .sass('resources/sass/theme_am/samgiits.scss', 'public/css/am')
    .sass('resources/sass/theme_am/svadhyaya_page.scss', 'public/css/am')
    .sass('resources/sass/theme_sadvipra/medForEve.scss', 'public/css/sadvipra')
    .sass('resources/sass/theme_sadvipra/callRequests.scss', 'public/css/sadvipra')
    .sass('resources/sass/sadvipra.scss', 'public/css')
    .sourceMaps(false, 'source-map').version();
