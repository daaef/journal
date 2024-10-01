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
                secondary: {
                    '50': '#fef4f2',
                    '100': '#fde7e3',
                    '200': '#fdd2cb',
                    '300': '#fab2a7',
                    '400': '#f48675',
                    '500': '#ea5f49',
                    '600': '#d7422b',
                    '700': '#b53420',
                    '800': '#962e1e',
                    '900': '#762a1e',
                    '950': '#43140c',
                },

            }
        },
        container: {
            center: true,
        },
        fontFamily: {
            sans: ['Montserrat', 'serif'],
        },
    },
    plugins: [
        require('preline/plugin')
    ],
}
