const mix = require('laravel-mix');
const CleanWebpackPlugin = require('clean-webpack-plugin')
const path = require('path');

mix.js('resources/js/login.js', 'public/js')
  .js('resources/js/backend.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/bootstrap.scss', 'public/css');

mix.webpackConfig({
  plugins: [
    new CleanWebpackPlugin(path.resolve(__dirname + '/public'), {
      verbose: true,
      exclude: ['index.php', 'mix-manifest.json', 'svg/', 'favicon.ico']
    })
  ]
});