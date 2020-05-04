let mix = require('laravel-mix');
const webpack = require('webpack');

// Includes dependancies in all files
// Else plugins cannot inject themselves into jQuery
mix.webpackConfig({
    plugins: [
        new webpack.ProvidePlugin({
            '$': 'jquery',
            'jQuery': 'jquery',
            'window.jQuery': 'jquery',
            'bootstrap': 'bootstrap'
        }),
    ]
});

// Main
mix.sass('resources/sass/app.scss', 'public/css')
    .copy('resources/js/global/*', 'public/js/global')

    // Assets and CSS
    .copy('resources/sass/global/*', 'public/css/global');

    // Index
    mix.js('resources/js/index/index.js', 'public/js/index')
        .copy('resources/sass/index/*', 'public/css/index');

    //Admin
    mix.copy('resources/sass/admin/*', 'public/css/admin');

    mix.copy('resources/sass/account/*', 'public/css/account');

    // Auth
    mix.copy('resources/sass/authentication/*', 'public/css/authentication');

    // Rooms
    mix.js('resources/js/room/join.js', 'public/js/room/join.js')
        .js('resources/js/room/index.js', 'public/js/room/index.js')
        .js('resources/js/room/sidebar.js', 'public/js/room/sidebar.js')
        .js('resources/js/room/show.js', 'public/js/room/show.bundle.js')
        .copy('resources/sass/room/*', 'public/css/room');

    // Battleplan
    mix.copy('resources/js/battleplan', 'public/js/battleplan')
        .copy('resources/js/battleplan/edit', 'public/js/battleplan')
        .js('resources/js/battleplan/edit/edit.js', 'public/js/battleplan/edit.bundle.js')
        .copy('resources/sass/battleplan/*', 'public/css/battleplan');
