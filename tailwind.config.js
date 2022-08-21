const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

function color_variables(name) {
    return {
        50: `var(--${name}-50)`,
        100: `var(--${name}-100)`,
        200: `var(--${name}-200)`,
        300: `var(--${name}-300)`,
        400: `var(--${name}-400)`,
        500: `var(--${name}-500)`,
        600: `var(--${name}-600)`,
        700: `var(--${name}-700)`,
        800: `var(--${name}-800)`,
        900: `var(--${name}-900)`,
    };
}

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/Components/**/*.vue",
        "./resources/js/Layouts/**/*.vue",
        "./resources/js/data/form/*.json",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            white: colors.white,
            gray: color_variables("gray"),
            red: color_variables("red"),
            green: color_variables("green"),
            yellow: color_variables("yellow"),
            blue: color_variables("blue"),
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
