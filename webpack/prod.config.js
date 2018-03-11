const webpack = require('webpack');
const path = require('path');
const WriteFilePlugin = require('write-file-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const CleanWebpackPlugin = require('clean-webpack-plugin');

const theme = 'jeffersonrise';

// define src & dist directories
const srcDir = path.resolve(__dirname, '../src/');
const assetsDir = path.resolve(__dirname, '../src/assets/');
const beagleDir = path.resolve(__dirname, '../src/assets/portal/beagle/');
const buildDir = path.resolve(__dirname, '../wordpress/wp-content/themes/' + theme);

// base prod webpack config
module.exports = {
    cache: true,
    devtool: 'source-map',
    stats: 'errors-only',
    entry: {
        web: assetsDir + '/web/index.js',
        portal: assetsDir + '/portal/index.js'
    },
    output: {
        path: buildDir + '/dist/',
        filename: '[name].min.js',
    },
    module : {
        loaders : [
            {
                test: /\.js$/,
                include: beagleDir,
                loaders: ['script-loader']
            },
            {
                test: /\.js$/,
                include: assetsDir,
                exclude: beagleDir,
                loaders: ['babel-loader?cacheDirectory=true']
            },
            {
                test: /\.(scss|css)$/,
                include: assetsDir,
                loaders: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: [
                        { loader: 'css-loader', options: { sourceMap: true }},
                        { loader: 'resolve-url-loader' },
                        { loader: 'sass-loader', options: { sourceMap: true, outputStyle: 'compact' }}
                    ]
                })
            },
            {
                test: /\.(png|jpg|gif|svg|eot|woff|woff2|ttf)$/,
                include: assetsDir,
                loaders: ['file-loader']
            }
        ]
    },
    plugins: [
        new CleanWebpackPlugin(['dist'], {
            root: buildDir
        }),
        new ExtractTextPlugin({
            filename: '[name].min.css'
        }),
        new WriteFilePlugin({
            test: /\.(css|png|jpg|php)$/,
            log: false,
        }),
        new CopyWebpackPlugin([{ from: srcDir, to: buildDir }], { ignore: ['assets/**/*'] })
    ]
};