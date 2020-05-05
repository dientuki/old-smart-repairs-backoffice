// Native Node modules.
const path = require("path");

const baseDir = path.resolve(__dirname, "..");

module.exports = {
    base: baseDir,
    dist: path.resolve(baseDir, "public", "dist"),
    fonts: path.resolve(baseDir, "public", "fonts"),
    resources: {
        fonts: path.resolve(baseDir, "resources", "fonts"),
        images: path.resolve(baseDir, "resources", "images")
    },
    publicPath: '',
}