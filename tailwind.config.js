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
                'neon-blue': '#3b82f6',
                'neon-pink': '#ec4899',
                'neon-purple': '#8b5cf6',
            },
            backgroundImage: {
                'gradient-futuristic': 'linear-gradient(135deg, #3b82f6, #8b5cf6, #ec4899)',
            },
        },
    },

    darkMode: 'class', // sudah benar
    theme: {
        extend: {
            colors: {
                'light-bg': '#f3f4f6', // Light Mode background (mirip landing page)
                'light-card': 'rgba(255,255,255,0.1)', // Light Mode card
                'light-border': 'rgba(255,255,255,0.2)',
                'dark-bg': '#1f2937', // Dark Mode background elegan
                'dark-card': '#111827',
                'dark-border': '#374151',
                'neon-blue': '#3b82f6',
                'neon-pink': '#ec4899',
                'neon-purple': '#8b5cf6',
            },
            backgroundImage: {
                'gradient-futuristic': 'linear-gradient(135deg, #3b82f6, #8b5cf6, #ec4899)',
            },
        },
    },
    plugins: [require('@tailwindcss/forms')],

    plugins: [forms],
};
