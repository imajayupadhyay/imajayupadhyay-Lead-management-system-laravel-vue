import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0f172a',
                },
            },
            backgroundImage: {
                'navy-gradient': 'linear-gradient(135deg, #1e293b 0%, #334155 100%)',
                'navy-gradient-light': 'linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #cbd5e1 100%)',
                'navy-gradient-header': 'linear-gradient(90deg, #1e293b 0%, #334155 100%)',
                'navy-gradient-card': 'linear-gradient(145deg, #ffffff 0%, #f8fafc 100%)',
            },
        },
    },

    plugins: [forms],
};