const paths = require("./paths");
console.log(`Mode: ${process.env.NODE_ENV}`);

const entries = require('./entries');
const output = require('./output');
const rules = require('./rules');
const plugins = require('./plugins');
const optimization = require('./optimization');

module.exports = {
  mode: process.env.NODE_ENV,
  devtool: process.env.NODE_ENV == 'development' ? "source-map" : "none",
  entry: entries,
  output: output,
  module: {
    rules: rules
  },
  plugins: plugins,
  optimization: optimization,
  performance: {
    hints: false
  }
}