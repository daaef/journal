/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "node_modules/preline/dist/*.js"
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    '50': '#fff8ed',
                    '100': '#fff0d4',
                    '200': '#ffdea8',
                    '300': '#ffc570',
                    '400': '#ffa137',
                    '500': '#ff830c',
                    '600': '#f06906',
                    '700': '#c74e07',
                    '800': '#9e3e0e',
                    '900': '#7f350f',
                    '950': '#451805',
                },
            }
        },
    },
    plugins: [
        require('preline/plugin')
    ],
}
