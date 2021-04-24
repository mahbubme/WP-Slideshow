const path = require("path");
const appEnv = 'production';
const wpPot = require('wp-pot');

wpPot({
    destFile: './languages/wp-slideshow.pot',
    domain: 'wp-slideshow',
    package: 'wp-slideshow',
});

module.exports = {
    mode: appEnv,
    entry: {
        "./assets/js/min/frontend.min": "./assets/js/frontend.js",
        "./assets/js/min/admin.min": "./assets/js/admin.js"
    },
    output: {
        path: path.resolve(__dirname),
        filename: "[name].js"
    },
    watch: false,
    module: {
        rules: [
        ],
    },
    plugins: [
    ]
};
