const webpack = require('webpack');
const path = require('path');
const WriteFilePlugin = require('write-file-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin')

const theme = 'hipurefiltration';

// define src & dist directories
const srcDir = path.resolve(__dirname, '../src/');
const assetsDir = path.resolve(__dirname, '../src/assets/');
const buildDir = path.resolve(__dirname, '../wordpress/wp-content/themes/' + theme);

// dev server config
const serverConfig = {
    host: 'localhost',
    scheme: 'http',
    port: 3001,
    url: function () {
        return this['scheme'] + '://' + this['host'] + ':' + this['port'] + '/';
    }
};

// base dev webpack config
module.exports = {
    cache: true,
    devtool: 'source-map',
    stats: 'errors-only',
    entry: {
        web: assetsDir + '/index.js'
    },
    output: {
        path: buildDir,
        filename: '[name].min.js',
        publicPath: serverConfig.url() + 'dist/'
    },
    devServer: {
        hot: true,
        stats: 'errors-only',
        clientLogLevel: 'none',
        contentBase: buildDir,
        publicPath: serverConfig.url() + 'dist/',
        https: serverConfig.scheme == 'https',
        port: serverConfig.port,
        headers: {
            'Access-Control-Allow-Origin': 'http://localhost:9000',
        }
    },
    module : {
        loaders : [
            {
                test: /\index.js|js\/*.js/,
                include: assetsDir,
                loaders: ['babel-loader?cacheDirectory=true']
            },
            {
                test: /\.(scss|css)$/,
                include: assetsDir,
                loaders: ['style-loader', 'css-loader?sourceMap', 'resolve-url-loader', 'sass-loader?sourceMap']
            },
            {
                test: /\.(png|jpg|gif|svg|eot|woff|ttf|woff2)$/,
                include: assetsDir,
                loaders: ['url-loader']
            }
        ]
    },
    plugins: [
        new webpack.NamedModulesPlugin(),
        new webpack.HotModuleReplacementPlugin(),
        new WriteFilePlugin({
            test: /\.(css|png|jpg|php|ico)$/,
        }),
        new CopyWebpackPlugin([
            { from: srcDir, to: buildDir }
        ], { ignore: ['assets/**/*'], copyUnmodified: true })
    ]
};