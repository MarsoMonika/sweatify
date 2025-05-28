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
        },
    },

    plugins: [forms],

    variants: {
        extend: {
            backgroundColor: ['hover', 'focus', 'active'],
            textColor: ['hover', 'focus'],
            borderColor: ['hover', 'focus'],
            opacity: ['hover', 'focus'],
            transform: ['hover', 'focus'],
        },
    },
};
