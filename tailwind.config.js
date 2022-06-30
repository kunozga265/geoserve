const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            colors: {
                primary: '#05247d',
            }
           /* fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },*/
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require('flowbite/plugin')],
};
