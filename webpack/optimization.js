const optimization = {};
const minimizer = [];

optimization['splitChunks'] = {
  chunks: 'all',
  cacheGroups: {
    default: false,
    vendors: false,
  }
};

if (process.env.NODE_ENV == 'production') {
  const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
  const TerserPlugin = require('terser-webpack-plugin');

  optimization['minimize'] = true;

  minimizer.push(
    new TerserPlugin({
      sourceMap: false,
      terserOptions: {
        ecma: 6,
        output: { beautify: false },
        compress: {
          unused: true,
          dead_code: true
        },
        warnings: false,
        mangle: true,
        ie8: false,
        safari10: false
      }
    })
  );

  minimizer.push(new OptimizeCSSAssetsPlugin({}));

  optimization['minimizer'] = minimizer;

}

if (process.env.NODE_ENV == 'development') {
  optimization['removeAvailableModules'] = false;
  optimization['removeEmptyChunks'] = false;
}

module.exports = optimization;