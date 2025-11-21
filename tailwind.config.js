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
                'kaki': {
                    50: '#f9f8f4',
                    100: '#f0ede3',
                    200: '#e1d9c3',
                    300: '#cdc09d',
                    400: '#b8a579',
                    500: '#a89364',
                    600: '#8f7a52',
                    700: '#766244',
                    800: '#62513c',
                    900: '#534535',
                },
                'vtuber': {
                    rose: '#ff6b9d',
                    violet: '#9d4edd',
                    cyan: '#00f5ff',
                    neon: '#39ff14',
                },
                'dark': {
                    700: '#16213e',
                    800: '#1a1a2e',
                    900: '#0f0f1a',
                },
                'gold': {
                    DEFAULT: '#d4af37',
                    'light': '#e6c158',
                },
                'brand-text': {
                    DEFAULT: '#3e2f24',
                    'secondary': '#786b5e',
                }
            },
            backgroundImage: {
                'gradient-vtuber': 'linear-gradient(to right, #ff6b9d, #9d4edd, #00f5ff)',
                'gradient-gold': 'linear-gradient(to right, #d4af37, #e6c158)',
                'gradient-body': 'linear-gradient(to bottom, #f9f8f4, #FFFFFF, #f0ede3)',
                'gradient-footer': 'linear-gradient(to bottom, #62513c, #534535)',
            },
            dropShadow: {
                'neon': '0 0 10px rgba(57, 255, 20, 0.7)',
            }
        },
    },

    plugins: [forms],
};
