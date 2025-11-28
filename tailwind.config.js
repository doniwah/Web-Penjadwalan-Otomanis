import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#E1F5FE', // Light Blue 50
                secondary: '#FFFFFF', // White
                accent: '#039BE5', // Light Blue 600
                dark: '#01579B', // Light Blue 900
            }
        },
    },

    plugins: [forms],
};
