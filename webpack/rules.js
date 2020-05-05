const paths = require("./paths");
const rules = [];

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const names = process.env.NODE_ENV == 'development' ? '[name]-[hash].[ext]' : '[hash].[ext]';

/* javascripts */
rules.push({
  test: /\.js$/,
  exclude: /(node_modules|dist|js)/,
  use: {
    loader: 'babel-loader',
    options: {
      cacheDirectory: true
    }
  }
});

/* jsx */  
rules.push({
  test: /\.jsx$/,
  exclude: /(node_modules)/,
  use: {
    loader: 'babel-loader',   
  }
});  

/* styles */
rules.push({
  test: /\.scss$/,
  use: [
    MiniCssExtractPlugin.loader,
    {loader: 'css-loader', options: { importLoaders: 1 }},
    'postcss-loader',
    {loader: 'sass-loader', options: {precision: 2}}
  ],
});

/* images */
rules.push({
  test: /\.(png|jpg|gif|svg)$/,
  include: [
    paths.resources.images
  ],
  use: [
    {loader: 'file-loader',
      options: {
        hashType:'sha512',
        digestType: 'hex',
        name: names,
        outputPath: 'images/'
      }
    },
    {
      loader: 'image-webpack-loader',
      options: {
        mozjpeg: {
          progressive: true,
          quality: 80
        },
      }
    }
  ]
});

/* fonts */
rules.push({
  test: /\.(woff|woff2)$/,
  include: [
    paths.resources.fonts
  ],
  use: [
    {loader: 'file-loader',
      options: {
        hashType:'sha512',
        digestType: 'hex',
        name: names,
        outputPath: 'fonts/'
      }
    }
  ]
});

module.exports = rules;  