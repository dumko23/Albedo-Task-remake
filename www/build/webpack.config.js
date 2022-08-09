const path = require('path')
const { SRC, DIST, ASSETS } = require('./paths')

module.exports = {
    entry: {
        scripts: path.resolve(SRC, 'views/js', 'index.js'),
        styles: path.resolve(SRC, 'views/css', 'index.css')
    },
    output: {
        // Put all the bundled stuff in your dist folder
        path: DIST,

        // Our single entry point from above will be named "scripts.js"
        filename: '[name].js',

        // The output path as seen from the domain we're visiting in the browser
        publicPath: ASSETS
    },
    module: {
        rules: [
            {
                test: /\.css$/i,
                use: ['style-loader', 'css-loader'],
            },
            {
                test: /\.(png|jpg|jpeg)$/i,
                type: 'asset/resource',
            },
        ],
    },
}
