const mix = require('laravel-mix');
let httpRequest = require('request')
let criticalCSS = require('critical')

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

mix.options({
    postCss: [
        require('autoprefixer'),
    ],
});

mix.setPublicPath('public');

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue'],
        alias: {
            '@': __dirname + 'resources'
        }
    },
    output: {
        chunkFilename: 'js/chunks/[name].[chunkhash].js',
    },
});

mix.react('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css').version();


//Then we will generate critical css...
mix.then(() => {
    console.log("Build Post-Processing...")

    const criticalRoutes = [
        {
            url: 'http://develop.project.ru:8800/',
            save: 'critical.css'
        },
    ]

    criticalRoutes.forEach((route) => {

        /**
         * Fetch Page Urls from Local Server
         * @docs https://www.npmjs.com/package/request
         */
        console.log("Fetching Critical CSS Paths...", route.url)

        httpRequest(route.url, (error, response, body) => {

            /** Stop on Empty Body String */
            if (!body) {
                throw new Error("Response Body Empty!")
            }
            /** Stop on HTTP Error */
            if (error) {
                throw new Error(error)
            }

            /**
             * Generate Critical CSS Path
             * @docs https://github.com/addyosmani/critical
             */
            console.log("Processing Critical CSS Paths...", route.url)

            criticalCSS.generate({
                inline: false,
                base: 'public/css/',
                html: body,
                css: ['app.css'],
                width: 1300,
                height: 900,
                target: {
                    css: route.save,
                },
                minify: true,
                extract: false,
                ignore: ['@font-face', /url\(/],

            });
        })
    })
})
