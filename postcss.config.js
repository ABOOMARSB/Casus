// const plugin = require("postcss-preset-env");
module.exports = {
    plugins: [
        require("postcss-preset-env"),
        require("tailwindcss"),
        require("autoprefixer"),
    ],
};