import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbitePlugin from 'flowbite/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
        './resources/**/*.{vue,js,ts,jsx,tsx}',
        './src/**/*.{vue,js,ts,jsx,tsx}',
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                mont: ['Montserrat', 'sans-serif'],
            },
            colors: {
                'custom-blue': '#0060e6',
            },
            backgroundColor: {
                'custom-bg': 'var(--primary-color-level4)',
            },
        },
    },

    plugins: [
        forms,
        flowbitePlugin,
    ],
};
