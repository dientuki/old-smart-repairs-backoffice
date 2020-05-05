const paths = require("./paths");
const output = {
    publicPath: paths.publicPath,
    path: paths.dist,
    pathinfo: false
};

if (process.env.NODE_ENV == 'development') {
    output['filename'] = '[name]-[chunkhash].js';
    output['chunkFilename'] = '[name]-[chunkhash].js';
} else {
    output['filename'] = '[chunkhash].js';
    output['chunkFilename'] ='[chunkhash].js';
}

module.exports = output;